<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $subcategories = [
            // Books (main_category_id = 1)
            ['main_category_id' => 1, 'name' => 'Novels'],
            ['main_category_id' => 1, 'name' => 'Educational'],

            // Magazines (main_category_id = 2)
            ['main_category_id' => 2, 'name' => 'Technology'],
            ['main_category_id' => 2, 'name' => 'Lifestyle'],

            // Research Papers (main_category_id = 3)
            ['main_category_id' => 3, 'name' => 'Science'],
            ['main_category_id' => 3, 'name' => 'Engineering'],
        ];

        foreach ($subcategories as $sub) {
            Subcategory::create($sub);
        }
    }
}
