<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $category_names=['boots','sandals','sneakers'];
        foreach($category_names as $category_name)
        {
            $category=Category::create(
                [
                    'name'=>$category_name,
                    'discount'=>$category_name=='boots'??30
                ]
            );
            if($category_name=='boots')
            {
                $category->products()->createMany(
                [
                    "sku" => "000001",
                    "name" => "BV Lean leather ankle boots",
                    "price" => 8900000
                ],
                [
                    "sku" => "000002",
                    "name" => "BV Lean leather ankle boots",
                    "price" => 9900000
                ],
                [
                    "sku" => "000003",
                    "name" => "Ashlington leather ankle boots",
                    "price" => 7100000,
                    "discount"=>15
                ]
            );
            }

            if($category_name=='sandals')
            {
                $category->products()->create(
                [
                    "sku" => "000004",
                    "name" => "Naima embellished suede sandals",
                    "category" => "sandals",
                    "price" => 7950000
                ]
                );
            }

            if($category_name=='sneakers')
            {
                $category->products()->create(
                    [
                        "sku" => "000005",
                        "name" => "Nathane leather sneakers",
                        "price" => 5900000
                    ]
                )
            }
        }
    }
}
