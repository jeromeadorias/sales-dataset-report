<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use App\Models\Salesperson;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $salesData = [
            [
                'date' => '2023-10-11',
                'product_name' => 'Headphones',
                'category_name' => 'Accessories',
                'region_name' => 'East',
                'salesperson_name' => 'Ethan',
                'units_sold' => 19,
                'unit_price' => 1169,
                'total_sales' => 22211,
            ],
            [
                'date' => '2023-06-05',
                'product_name' => 'Laptop',
                'category_name' => 'Electronics',
                'region_name' => 'North',
                'salesperson_name' => 'Bob',
                'units_sold' => 14,
                'unit_price' => 1649,
                'total_sales' => 23086,
            ],
            [
                'date' => '2023-04-22',
                'product_name' => 'Tablet',
                'category_name' => 'Electronics',
                'region_name' => 'West',
                'salesperson_name' => 'Charlie',
                'units_sold' => 13,
                'unit_price' => 1508,
                'total_sales' => 19504,
            ],
            [
                'date' => '2023-10-23',
                'product_name' => 'Smartwatch', // <-- Make sure Smartwatch exists in products
                'category_name' => 'Accessories',
                'region_name' => 'South',
                'salesperson_name' => 'Diana',
                'units_sold' => 8,
                'unit_price' => 1781,
                'total_sales' => 14248,
            ],
            [
                'date' => '2023-07-01',
                'product_name' => 'Headphones',
                'category_name' => 'Accessories',
                'region_name' => 'South',
                'salesperson_name' => 'Ethan',
                'units_sold' => 5,
                'unit_price' => 121,
                'total_sales' => 605,
            ],
            [
                'date' => '2023-07-31',
                'product_name' => 'Smartphone',
                'category_name' => 'Electronics',
                'region_name' => 'West',
                'salesperson_name' => 'Bob',
                'units_sold' => 4,
                'unit_price' => 549,
                'total_sales' => 2196,
            ],
        ];

        foreach ($salesData as $sale) {
            $product = Product::where('name', $sale['product_name'])->first();
            $category = Category::where('name', $sale['category_name'])->first();
            $region = Region::where('name', $sale['region_name'])->first();
            $salesperson = Salesperson::where('name', $sale['salesperson_name'])->first();

            if (!$product || !$category || !$region || !$salesperson) {
                throw new \Exception("Missing related data for sale entry: " . json_encode($sale));
            }

            DB::table('sales')->insert([
                'date' => $sale['date'],
                'product_id' => $product->id,
                'category_id' => $category->id,
                'region_id' => $region->id,
                'salesperson_id' => $salesperson->id,
                'units_sold' => $sale['units_sold'],
                'unit_price' => $sale['unit_price'],
                'total_sales' => $sale['total_sales'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
