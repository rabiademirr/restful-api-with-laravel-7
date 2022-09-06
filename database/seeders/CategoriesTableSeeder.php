<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{

    public function run()
    {
        //DB::statement("TRUNCATE TABLE categories");

        for ($i = 0; $i < 20; $i++) {
            DB::table('categories')->insert([
                'name' => Str::random(10),
                'published' => 1,
            ]);
        }


        for ($i = 2; $i < 30; $i++) {
            DB::table('product_categories')->insert([
                'product_id' => rand(20, 100),
                'category_id' => rand(1,26)
            ]);
        }


    }
}
