<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APIFeaturesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_endpoint_is_working(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_json_sturcture_is_correct():void
    {
        $response = $this->get('/products');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'sku',
                    'name',
                    'category',
                    'price' => [
                        'original',
                        'final',
                        'discount_percentage',
                        'currency'
                    ]
                ]
            ]
        ]);
    }

    public function test_category_filter_returns_category_products():void
    {
        $response = $this->get('/products?category=boots');
        $response->assertJsonCount(3, $key = 'data')
        ->assertJsonFragment([
            'category'=>'boots'
        ]);;
    }
    public function test_category_filter_returns_no_product_for_empty_category():void
    {
        $response = $this->get('/products?category=shirts');
        $response->assertJsonCount(0, $key = 'data');
    }
    public function test_priceLessThan_filter_returns_products_with_price_less_than_or_equal_to_parameter():void
    {
        $response = $this->get('/products?priceLessThan=75000');
        $response->assertJsonCount(2, $key = 'data');
    }
    public function test_must_return_atmost_5_elements():void
    {
        $response = $this->get('/products');
        $response->assertJsonCount(5, $key = 'data');
    }
}
