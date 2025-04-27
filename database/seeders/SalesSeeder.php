<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\Category;
// use App\Models\Product;
// use App\Models\Region;
// use App\Models\Salesperson;
// use App\Models\Sale;
// use Faker\Factory as Faker;

// class SalesSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $faker = Faker::create();

//         // Create categories
//         $categories = collect([
//             'Electronics', 'Accessories'
//         ])->map(function ($name) {
//             return Category::firstOrCreate(['name' => $name]);
//         });

//         // Create products
//         $products = collect([
//             'Laptop', 'Table', 'Headset', 'Smartwatch'
//         ])->map(function ($name) use ($categories) {
//             return Product::firstOrCreate([
//                 'name' => $name,
//                 'category_id' => $categories->random()->id, // 🛠 Fixed here
//             ]);
//         });

//         // Create regions
//         $regions = collect([
//             'East', 'West', 'North', 'South'
//         ])->map(function ($name) {
//             return Region::firstOrCreate(['name' => $name]);
//         });

//         // Create salespersons
//         $salespersons = collect([
//             'Ethan', 'Charlie', 'Alice', 'Bob'
//         ])->map(function ($name) {
//             return Salesperson::firstOrCreate(['name' => $name]);
//         });

//         // Create 500 dummy sales
//         for ($i = 0; $i < 500; $i++) {
//             $product = $products->random();
//             $region = $regions->random();
//             $salesperson = $salespersons->random();

//             $unitsSold = $faker->numberBetween(1, 20);
//             $unitPrice = $faker->randomFloat(2, 100, 5000);
//             $totalSales = $unitsSold * $unitPrice;

//             Sale::create([
//                 'date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
//                 'product_id' => $product->id,
//                 'region_id' => $region->id,
//                 'salesperson_id' => $salesperson->id,
//                 'units_sold' => $unitsSold,
//                 'unit_price' => $unitPrice,
//                 'total_sales' => $totalSales,
//             ]);
//         }
//     }
// } -->


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Region;
use App\Models\Salesperson;
use App\Models\Sale;
use Faker\Factory as Faker;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create categories
        $categories = collect([
            'Electronics', 'Accessories'
        ])->map(function ($name) {
            return Category::firstOrCreate(['name' => $name]);
        });

        // Create products
        $products = collect([
            'Laptop', 'Tablet', 'Headset', 'Smartwatch'
        ])->map(function ($name) use ($categories) {
            return Product::firstOrCreate([
                'name' => $name,
                'category_id' => $categories->random()->id,
            ]);
        });

        // Create regions
        $regions = collect([
            'East', 'West', 'North', 'South'
        ])->map(function ($name) {
            return Region::firstOrCreate(['name' => $name]);
        });

        // Create salespersons
        $salespersons = collect([
            'Ethan', 'Charlie', 'Alice', 'Bob'
        ])->map(function ($name) {
            return Salesperson::firstOrCreate(['name' => $name]);
        });

        // Create sales
        $this->generateSales($products, $regions, $salespersons, 500);
    }

    private function generateSales($products, $regions, $salespersons, $count = 100)
    {
        $faker = Faker::create();

        for ($i = 0; $i < $count; $i++) {
            $unitsSold = $faker->numberBetween(1, 20);
            $unitPrice = $faker->randomFloat(2, 100, 5000);

            Sale::create([
                'date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'product_id' => $products->random()->id,
                'region_id' => $regions->random()->id,
                'salesperson_id' => $salespersons->random()->id,
                'units_sold' => $unitsSold,
                'unit_price' => $unitPrice,
                'total_sales' => $unitsSold * $unitPrice,
            ]);
        }
    }
}
