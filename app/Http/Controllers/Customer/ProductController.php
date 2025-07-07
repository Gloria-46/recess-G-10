<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $category = request('category');
        $query = Product::where('is_active', true);
        if ($category && in_array($category, ['ladies', 'gentlemen'])) {
            $query->where('category', $category);
        }
        $products = $query->latest()->get();
        return view('customer.products', compact('products', 'category'));
    }

    public function show($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('customer.product_details', compact('product'));
    }

    public function search() 
    {
        $query = request('query');
        $products = [];
        if ($query) {
            $products = Product::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                      ->orWhere('description', 'like', "%$query%")
                      ;
                })
                ->latest()
                ->get();
        }
        $showSearchBar = true;
        return view('customer.products', compact('products', 'showSearchBar', 'query'));
    }
} 