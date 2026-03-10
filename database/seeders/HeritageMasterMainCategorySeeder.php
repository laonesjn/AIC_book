<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HeritageMasterMainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('heritage_master_main_categories')->insert([
            [
                'name' => 'Religion, Belief, and Worldviews',
                'view_count' => 120,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Built Heritage, Architecture, and Place',
                'view_count' => 85,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Language, Writing, and Literary Heritage',
                'view_count' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Social Structures, Law, and Community Organisation',
                'view_count' => 42,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rituals, Festivals, and Intangible Cultural Heritage',
                'view_count' => 91,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Dress, Food, and Everyday Material Culture',
                'view_count' => 37,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Environmental Knowledge and Economic Life',
                'view_count' => 58,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Education, Science, and Knowledge Systems',
                'view_count' => 73,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Media, Memory, and Contemporary Culture',
                'view_count' => 110,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Diaspora, Migration, and Transnational Heritage',
                'view_count' => 49,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
