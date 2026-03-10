<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainCategory;

class MainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Books',
            'Magazines',
            'Research Papers',
            'Newspapers',
        ];

        foreach ($categories as $name) {
            MainCategory::create([
                'name' => $name,
            ]);
        }
    }
}
