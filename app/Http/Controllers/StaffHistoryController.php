<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Collection;
use App\Models\HeritageCollection;
use App\Models\Publication;
use App\Models\Exhibition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffHistoryController extends Controller
{
    private $modules = [
        'collection' => [
            'name' => 'Collection',
            'model' => Collection::class,
            'title_field' => 'title', // Assuming title or name
            'icon' => 'bi-collection'
        ],
        'heritage' => [
            'name' => 'Heritage Collection',
            'model' => HeritageCollection::class,
            'title_field' => 'title',
            'icon' => 'bi-bank'
        ],
        'publications' => [
            'name' => 'Publications',
            'model' => Publication::class,
            'title_field' => 'title',
            'icon' => 'bi-journal-text'
        ],
        'exhibition' => [
            'name' => 'Virtual Exhibition',
            'model' => Exhibition::class,
            'title_field' => 'title',
            'icon' => 'bi-easel'
        ],
        'members' => [
            'name' => 'Members',
            'model' => User::class,
            'title_field' => 'name',
            'icon' => 'bi-people'
        ],
    ];

    public function index()
    {
        return view('admin.staff.history.index', ['modules' => $this->modules]);
    }

    public function items(string $moduleKey, Request $request)
    {
        if (!isset($this->modules[$moduleKey])) {
            abort(404);
        }

        $module = $this->modules[$moduleKey];
        $query = ($module['model'])::query();

        if ($moduleKey === 'members') {
            $query->where('role', 'client');
        }

        if ($request->filled('search')) {
            $query->where($module['title_field'], 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(15);

        return view('admin.staff.history.items', [
            'moduleKey' => $moduleKey,
            'module' => $module,
            'items' => $items
        ]);
    }

    public function show(string $moduleKey, int $id)
    {
        if (!isset($this->modules[$moduleKey])) {
            abort(404);
        }

        $module = $this->modules[$moduleKey];
        $item = ($module['model'])::find($id);

        if (!$item) {
            // Check if it was deleted by looking in audit logs
            $logs = AuditLog::where('model_type', $module['model'])
                ->where('model_id', $id)
                ->with('admin')
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($logs->isEmpty()) {
                abort(404);
            }
            
            $itemName = "Deleted Item (ID: $id)";
            // Try to find name in last log's changes
            $lastLog = $logs->first();
            if (isset($lastLog->changes['before'][$module['title_field']])) {
                $itemName = $lastLog->changes['before'][$module['title_field']];
            }
        } else {
            $itemName = $item->{$module['title_field']};
            $logs = AuditLog::where('model_type', $module['model'])
                ->where('model_id', $id)
                ->with('admin')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.staff.history.show', [
            'moduleKey' => $moduleKey,
            'module' => $module,
            'itemName' => $itemName,
            'logs' => $logs
        ]);
    }
}
