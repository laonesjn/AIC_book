<?php
// database/seeders/PermissionSeeder.php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed all module × action permission combinations.
     *
     * Run once after migration:
     *   php artisan db:seed --class=PermissionSeeder
     *
     * Safe to re-run — uses updateOrCreate to avoid duplicates.
     */
    public function run(): void
    {
        $modules = [
            'collections'  => 'Collections',
            'heritage'     => 'Heritage',
            'publications' => 'Publications',
            'exhibitions'  => 'Virtual Exhibitions',
            'members'      => 'Members',
        ];

        $actions = [
            'view'   => 'View',
            'create' => 'Create',
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ];

        foreach ($modules as $moduleKey => $moduleLabel) {
            foreach ($actions as $actionKey => $actionLabel) {
                Permission::updateOrCreate(
                    ['module' => $moduleKey, 'action' => $actionKey],
                    [
                        'label'       => "{$actionLabel} {$moduleLabel}",
                        'description' => "Allows the staff member to {$actionKey} {$moduleLabel}.",
                    ]
                );
            }
        }

        $this->command->info('Permissions seeded: ' . (count($modules) * count($actions)) . ' rows.');
    }
}