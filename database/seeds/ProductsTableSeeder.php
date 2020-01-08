<?php

use Illuminate\Database\Seeder;
use App\Dashboard\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['product one', 'product two'];

        foreach($products as $product){
            Product::create([
                'ar' => [ 'name' => $product . ' ar', 'description' => $product . ' description ar' ],
                'en' => [ 'name' => $product . ' en', 'description' => $product . ' description en' ],
                'category_id' => rand(1, 2),
                'purchase_price' => rand(100, 300),
                'sale_price' => rand(350, 500),
                'stock' => 100
            ]);
        }
    }
}
