<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoProductsSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = public_path('data/products.json');
        if (!file_exists($jsonPath)) {
            return;
        }

        $items = json_decode(file_get_contents($jsonPath), true);
        if (!$items) {
            return;
        }

        // Map categories from categories.json if needed
        $catMap = [
            1 => 'Salud y Bienestar',
            2 => 'Servicios Profesionales',
            3 => 'Tecnología y Software',
            4 => 'Gastronomía y Alimentos',
            5 => 'Educación y Formación',
        ];

        // Create a default seller user for demo products
        $demoUser = User::firstOrCreate(
            ['email' => 'emprendedores@caleb.com'],
            [
                'name' => 'Emprendedores Caleb',
                'password' => bcrypt('password'),
                'role' => 'emprendedor',
            ]
        );

        foreach ($items as $item) {
            // Find or create store
            $storeName = $item['company'] ?? 'Emprendedor Caleb';
            $store = Store::firstOrCreate(
                ['name' => $storeName],
                [
                    'user_id' => $demoUser->id,
                    'slug' => Str::slug($storeName),
                    'address' => $item['address'] ?? 'Pereira',
                    'status' => 'active',
                ]
            );

            // Find category
            $catId = $item['categoryId'] ?? 1;
            $catName = $catMap[$catId] ?? 'Servicios Profesionales';
            $category = Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName)]
            );

            // Create Product if not exists
            $productName = $item['service'] ?? 'Producto Demo';
            Product::firstOrCreate(
                [
                    'store_id' => $store->id,
                    'name' => $productName,
                ],
                [
                    'category_id' => $category->id,
                    'slug' => Str::slug($productName) . '-' . Str::random(4),
                    'description' => $item['description'] ?? null,
                    'commercial_price' => $item['commercial_price'] ?? null,
                    'price' => $item['caleb'] ?? 10000,
                    'image' => $item['image'] ?? null,
                    'status' => 'active',
                ]
            );
        }
    }
}
