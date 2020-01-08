<?php

use Illuminate\Database\Seeder;
use App\Dashboard\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['cat one', 'cat two'];

        foreach( $categories as $category ){
            Category::create([
                'ar' => [ 'name' => $category . ' ar' ],
                'en' => [ 'name' => $category . ' en' ]
            ]);
        }
    }
}
