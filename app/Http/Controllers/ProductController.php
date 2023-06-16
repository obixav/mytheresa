<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validated = request()->validate([
            'priceLessThan' => 'integer',
        ]);
        $products = (new Product)->newQuery();
        if (request()->filled('category')) {
            $category = Category::where('name', request()->category)->first();
            if ($category) {
                $products->where('category_id', $category->id);
            }
        }
        if (request()->filled('priceLessThan')) {
            $products->where('price', '<=', intval(request()->priceLessThan) * 100);
        }
        $products = $products->paginate(5);

        return ProductResource::collection($products);
    }
}
