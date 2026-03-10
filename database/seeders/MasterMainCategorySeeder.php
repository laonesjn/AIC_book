<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterMainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $categories = [
            'Governance & Institutions',
            'Human Rights & Justice',
            'Conflict, Resistance & Peace',
            'Displacement & Recovery',
            'Media & Research',
            'Memory, Culture & Audio-Visual',
        ];

        foreach ($categories as $category) {
            DB::table('master_main_categories')->updateOrInsert(
                ['name' => $category],
                ['view_count' => 0, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
