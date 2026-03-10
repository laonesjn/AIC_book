<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExhibitionCategory;
class ExhibitionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExhibitionCategory::insert([
        ['name' => 'பண்டைய வரலாறு', 'image' => 'images/e1.png'],
        ['name' => 'அரசியல்', 'image' => 'images/e2.png'],
        ['name' => 'மோதலின் விளைவுகள்', 'image' => 'images/e3.png'],
        ['name' => 'முள்ளிவாய்க்கால்', 'image' => 'images/e4.jpg'],
        ['name' => 'தமிழ் கலை & கலாச்சாரம்', 'image' => 'images/e5.png'],
    ]);
    }
}
