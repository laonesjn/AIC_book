<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\RequestAccess;
use App\Models\Collection;
use App\Models\CollectionAccessRequest;
use App\Models\HeritageCollection;
use App\Models\HeritageCollectionAccessRequest;
use App\Models\Exhibition;
use App\Models\Enquiry;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stats Cards ───────────────────────────────────────────────────────

        $totalPublications      = Publication::count();
        $pendingPublications    = RequestAccess::where('status', 'pending')->count();
        $lastMonthPublications  = Publication::where('created_at', '>=', now()->subMonth())->count();
        $prevMonthPublications  = Publication::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
        $publicationGrowth      = $this->growthPercent($prevMonthPublications, $lastMonthPublications);

        $totalOrders            = RequestAccess::count();
        $processingOrders       = RequestAccess::where('status', 'pending')->where('pay_status', 'paid')->count();
        $lastMonthOrders        = RequestAccess::where('created_at', '>=', now()->subMonth())->count();
        $prevMonthOrders        = RequestAccess::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
        $ordersGrowth           = $this->growthPercent($prevMonthOrders, $lastMonthOrders);

        $totalCollections       = Collection::count() + HeritageCollection::count();
        $draftCollections       = Collection::where('access_type', 'Private')->count()
                                + HeritageCollection::where('access_type', 'Private')->count();
        $lastMonthCollections   = Collection::where('created_at', '>=', now()->subMonth())->count()
                                + HeritageCollection::where('created_at', '>=', now()->subMonth())->count();
        $prevMonthCollections   = Collection::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count()
                                + HeritageCollection::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
        $collectionsGrowth      = $this->growthPercent($prevMonthCollections, $lastMonthCollections);

        $totalExhibitions       = Exhibition::count();
        $lastMonthExhibitions   = Exhibition::where('created_at', '>=', now()->subMonth())->count();
        $prevMonthExhibitions   = Exhibition::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
        $exhibitionsGrowth      = $this->growthPercent($prevMonthExhibitions, $lastMonthExhibitions);

        // ── Chart Data (Activity Overview) ────────────────────────────────────

        $chartData = $this->getActivityChartData('7days');

        // ── Pending Publications ──────────────────────────────────────────────

        $pendingPublicationList = RequestAccess::with('publication')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // ── Recent Orders ─────────────────────────────────────────────────────

        $recentOrders = RequestAccess::with('publication')
            ->latest()
            ->take(5)
            ->get();

        // ── Recent Access Requests ────────────────────────────────────────────

        $collectionRequests = CollectionAccessRequest::with('collection')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        $heritageRequests = HeritageCollectionAccessRequest::with('collection')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        // ── Recent Activity Feed ──────────────────────────────────────────────

        $recentActivity = $this->buildActivityFeed();

        // ── Enquiries ─────────────────────────────────────────────────────────

        $pendingEnquiries = Enquiry::where('status', 'pending')->count();
        $recentEnquiries  = Enquiry::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            // Stats
            'totalPublications', 'pendingPublications', 'publicationGrowth',
            'totalOrders', 'processingOrders', 'ordersGrowth',
            'totalCollections', 'draftCollections', 'collectionsGrowth',
            'totalExhibitions', 'exhibitionsGrowth',
            'pendingEnquiries',
            // Tables
            'pendingPublicationList',
            'recentOrders',
            'collectionRequests',
            'heritageRequests',
            'recentEnquiries',
            // Chart
            'chartData',
            // Feed
            'recentActivity'
        ));
    }

    public function auditLogs()
    {
        $logs = AuditLog::with('admin')->latest()->paginate(20);
        return view('admin.audit_logs', compact('logs'));
    }

    // ── AJAX: Chart Data ──────────────────────────────────────────────────────

    public function chartData(Request $request)
    {
        $period = $request->get('period', '7days');
        return response()->json($this->getActivityChartData($period));
    }

    // ── AJAX: Approve Publication Request ────────────────────────────────────

    public function approveRequest(Request $request, $id)
    {
        $item = RequestAccess::findOrFail($id);
        $item->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Request approved successfully.']);
    }

    public function rejectRequest(Request $request, $id)
    {
        $item = RequestAccess::findOrFail($id);
        $item->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => 'Request rejected.']);
    }

    // ── AJAX: Approve Collection Access Request ───────────────────────────────

    public function approveCollectionRequest($id)
    {
        $item = CollectionAccessRequest::findOrFail($id);
        $item->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Collection access approved.']);
    }

    public function approveHeritageRequest($id)
    {
        $item = HeritageCollectionAccessRequest::findOrFail($id);
        $item->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Heritage access approved.']);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function growthPercent(int $prev, int $current): array
    {
        if ($prev == 0) {
            return ['value' => $current > 0 ? 100 : 0, 'direction' => 'up'];
        }
        $percent = round((($current - $prev) / $prev) * 100, 1);
        return [
            'value'     => abs($percent),
            'direction' => $percent >= 0 ? 'up' : 'down',
        ];
    }

    private function getActivityChartData(string $period): array
    {
        switch ($period) {
            case '30days':
                $days   = 30;
                $format = '%Y-%m-%d';
                break;
            case 'year':
                $days   = 365;
                $format = '%Y-%m';
                break;
            default: // 7days
                $days   = 7;
                $format = '%Y-%m-%d';
        }

        $from = now()->subDays($days);

        $publications = Publication::where('created_at', '>=', $from)
            ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as label"), DB::raw('COUNT(*) as count'))
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('count', 'label');

        $orders = RequestAccess::where('created_at', '>=', $from)
            ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as label"), DB::raw('COUNT(*) as count'))
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('count', 'label');

        // Build unified labels
        $labels = collect();

        if ($period === 'year') {
            for ($i = 11; $i >= 0; $i--) {
                $labels->push(now()->subMonths($i)->format('Y-m'));
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $labels->push(now()->subDays($i)->format('Y-m-d'));
            }
        }

        return [
            'labels'       => $labels->values(),
            'publications' => $labels->map(fn($l) => $publications[$l] ?? 0)->values(),
            'orders'       => $labels->map(fn($l) => $orders[$l] ?? 0)->values(),
        ];
    }

    private function buildActivityFeed(): array
    {
        $feed = [];

        // Latest publications
        Publication::latest()->take(3)->get()->each(function ($p) use (&$feed) {
            $feed[] = [
                'type'    => 'primary',
                'icon'    => 'bi-file-earmark-plus',
                'title'   => 'New Publication Added',
                'desc'    => '"' . \Str::limit($p->title, 40) . '" was published',
                'time'    => $p->created_at,
            ];
        });

        // Latest orders
        RequestAccess::latest()->take(3)->get()->each(function ($o) use (&$feed) {
            $feed[] = [
                'type'    => 'success',
                'icon'    => 'bi-check-circle',
                'title'   => 'New Access Request',
                'desc'    => $o->name . ' requested access',
                'time'    => $o->created_at,
            ];
        });

        // Latest enquiries
        Enquiry::latest()->take(2)->get()->each(function ($e) use (&$feed) {
            $feed[] = [
                'type'    => 'info',
                'icon'    => 'bi-envelope',
                'title'   => 'New Enquiry',
                'desc'    => $e->name . ': ' . \Str::limit($e->subject, 40),
                'time'    => $e->created_at,
            ];
        });

        // Latest exhibitions
        Exhibition::latest()->take(2)->get()->each(function ($ex) use (&$feed) {
            $feed[] = [
                'type'    => 'warning',
                'icon'    => 'bi-image',
                'title'   => 'Exhibition Added',
                'desc'    => '"' . \Str::limit($ex->title, 40) . '"',
                'time'    => $ex->created_at,
            ];
        });

        // Sort by time descending, take 6
        usort($feed, fn($a, $b) => $b['time'] <=> $a['time']);
        return array_slice($feed, 0, 6);
    }
}