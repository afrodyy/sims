<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Raket Badminton',
                'buy_price' => 10000,
                'sell_price' => 15000,
                'stock' => 35,
                'image_path' => 'product_images\46708885433_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Jersey Liverpool',
                'buy_price' => 1250000,
                'sell_price' => 1625000,
                'stock' => 150,
                'image_path' => 'product_images\98636975893_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Dumbell 5kg',
                'buy_price' => 80000,
                'sell_price' => 104000,
                'stock' => 25,
                'image_path' => 'product_images\68597114842_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Yoga Mat',
                'buy_price' => 120000,
                'sell_price' => 156000,
                'stock' => 30,
                'image_path' => 'product_images\28848563441_image_2.png'
            ],
            [
                'category_id' => 2,
                'name' => 'Gitar Akustik',
                'buy_price' => 1000000,
                'sell_price' => 1300000,
                'stock' => 10,
                'image_path' => 'product_images\83869007979_image_2.png'
            ],
            [
                'category_id' => 2,
                'name' => 'Drum Set',
                'buy_price' => 2200000,
                'sell_price' => 2860000,
                'stock' => 5,
                'image_path' => 'product_images\14273068932_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Bola Basket',
                'buy_price' => 60000,
                'sell_price' => 78000,
                'stock' => 40,
                'image_path' => 'product_images\88617176044_image_2.png'
            ],
            [
                'category_id' => 2,
                'name' => 'Piano Elektrik',
                'buy_price' => 3000000,
                'sell_price' => 3900000,
                'stock' => 3,
                'image_path' => 'product_images\65245078119_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Treadmill',
                'buy_price' => 2000000,
                'sell_price' => 2600000,
                'stock' => 7,
                'image_path' => 'product_images\80762867248_image_2.png'
            ],
            [
                'category_id' => 2,
                'name' => 'Biola',
                'buy_price' => 1400000,
                'sell_price' => 1820000,
                'stock' => 8,
                'image_path' => 'product_images\41884963242_image_2.png'
            ],
            [
                'category_id' => 1,
                'name' => 'Sepatu Lari',
                'buy_price' => 200000,
                'sell_price' => 260000,
                'stock' => 20,
                'image_path' => 'product_images\48305853181_User_image.jpeg'
            ],
        ];

        // Loop melalui setiap data produk dan masukkan ke dalam database
        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
