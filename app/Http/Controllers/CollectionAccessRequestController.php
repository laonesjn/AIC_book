<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollectionAccessRequest;

class CollectionAccessRequestController extends Controller
{
    // ---- Submit Access Request (Private) ----
    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'full_phone'    => 'nullable|string|max:20',
            'country_name'  => 'nullable|string|max:255',
            'why'           => 'required|string|min:10|max:1000',
        ], [
            'collection_id.required' => 'Collection is required.',
            'collection_id.exists'   => 'Invalid collection.',
            'name.required'          => 'Please enter your full name.',
            'email.required'         => 'Please enter your email address.',
            'email.email'            => 'Please enter a valid email address.',
            'phone.required'         => 'Please enter your phone number.',
            'why.required'           => 'Please provide a reason for requesting access.',
            'why.min'                => 'Reason must be at least 10 characters.',
        ]);

        // Check if already requested
        $exists = CollectionAccessRequest::where('collection_id', $validated['collection_id'])
            ->where('email', $validated['email'])
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a request for this collection. Please wait for approval.',
            ], 409);
        }

        CollectionAccessRequest::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Your access request has been submitted successfully. We will contact you soon.',
        ]);
    }

    public function index(Request $request)
    {
        $query = CollectionAccessRequest::with([
            'collection.masterMainCategory', // ✅ Fixed: use correct relationship name
        ])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name',  'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $requests      = $query->paginate(15)->withQueryString();
        $pendingCount  = CollectionAccessRequest::where('status', 'pending')->count();
        $approvedCount = CollectionAccessRequest::where('status', 'approved')->count();
        $rejectedCount = CollectionAccessRequest::where('status', 'rejected')->count();

        return view('admin.viewcollectionrequest', compact(
            'requests',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function updateStatus(CollectionAccessRequest $collectionAccessRequest, Request $httpRequest)
    {
        $httpRequest->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $collectionAccessRequest->update(['status' => $httpRequest->status]);

        return back()->with('success', 'Request status updated to ' . ucfirst($httpRequest->status) . '.');
    }
}