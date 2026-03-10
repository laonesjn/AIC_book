<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            static::logActivity($model, 'created');
        });

        static::updated(function ($model) {
            static::logActivity($model, 'updated');
        });

        static::deleted(function ($model) {
            static::logActivity($model, 'deleted');
        });
    }

    protected static function logActivity($model, string $action)
    {
        $admin = Auth::guard('admin')->user() ?? Auth::user();

        if (!$admin) {
            return;
        }

        $changes = null;
        if ($action === 'updated') {
            $changes = [
                'before' => array_intersect_key($model->getOriginal(), $model->getDirty()),
                'after' => $model->getDirty(),
            ];
        } elseif ($action === 'created') {
            $changes = ['after' => $model->getAttributes()];
        } elseif ($action === 'deleted') {
            $changes = ['before' => $model->getOriginal()];
        }

        AuditLog::create([
            'admin_id'   => $admin->id,
            'action'     => $action,
            'model_type' => get_class($model),
            'model_id'   => $model->id,
            'changes'    => $changes,
        ]);
    }
}
