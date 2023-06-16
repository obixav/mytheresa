<?php

namespace Tests\Unit;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class BusinessRulesTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function test_sku_has_discount(): void
    {
        $product = Product::where('sku', '000003')->first();
        $this->assertEquals($product->discount, 15);
    }
    public function test_boots_category_has_discount(): void
    {
        $category = Category::where('name', 'boots')->first();
        $this->assertEquals($category->discount, 30);
    }

    public function test_when_multiple_discounts_colide_biggest_discount_was_applied(): void
    {
        $product = Product::where('discount', '>', 0)->whereHas('category', function ($query) {
            $query->where('categories.discount', '>', 0);
        })->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertEquals($productr['price']['discount_percentage'], '30%');
    }
    public function test_currency_is_always_Eur(): void
    {
        $product = Product::inRandomOrder()->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertEquals($productr['price']['currency'], 'Eur');
    }
    public function test_when_a_product_does_not_have_a_discount_price_final_and_price_original_are_the_same(): void
    {
        $product = Product::where('discount', null)->whereHas('category', function ($query) {
            $query->where('categories.discount', null);
        })->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertEquals($productr['price']['original'], $productr['price']['final']);
    }
    public function test_when_a_product_does_not_have_a_discount_price_let_discount_percentage_be_null(): void
    {
        $product = Product::where('discount', null)->whereHas('category', function ($query) {
            $query->where('categories.discount', null);
        })->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertNull($productr['price']['discount_percentage']);
    }
    public function test_when_a_product_has_a_discount_price_final_is_price_original_with_discount_applied(): void
    {
        $product = Product::where('discount', '>', 0)->orWhereHas('category', function ($query) {
            $query->where('categories.discount', '>', 0);
        })->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertEquals($productr['price']['final'], round($productr['price']['original'] * ((100 - intval($productr['price']['discount_percentage'])) / 100)));
    }
    public function test_discount_percentage_represents_applied_discount_with_percentage_sign(): void
    {
        $product = Product::where('discount', '>', 0)->orWhereHas('category', function ($query) {
            $query->where('categories.discount', '>', 0);
        })->first();
        $productr = new ProductResource($product);
        $productr = $productr->toArray(request());
        $this->assertTrue(str_contains($productr['price']['discount_percentage'], '%'));
    }
}
