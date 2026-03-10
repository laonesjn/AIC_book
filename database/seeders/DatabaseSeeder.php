<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        $this->call(UserSeeder::class);

        //---------------Publication seeder ---------------//
        $this->call(MainCategorySeeder::class);
        $this->call(SubcategorySeeder::class);
        $this->call(PublicationSeeder::class);


        //---------------CollectionsTableSeeder seeder ---------------//
        $this->call(MasterMainCategorySeeder::class);
        // $this->call(CollectionsTableSeeder::class);


        //  //---------------CollectionsTableSeeder seeder ---------------//
        $this->call([HeritageMasterMainCategorySeeder::class]);
        // // $this->call([HeritageCollectionSeeder::class]);


        $this->call([ExhibitionCategorySeeder::class]);
        // $this->call([PermissionSeeder::class]);



          



        

        


        
        



    }
}

