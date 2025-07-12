<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    // Return recommendations for the authenticated customer
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('customer.login');
        }

        // ML Recommendations
        $recommendationIds = DB::table('user_recommendations')
            ->where('user_id', $user->id)
            ->orderByDesc('score')
            ->limit(10)
            ->pluck('product_id');

        $recommendations = DB::table('products')
            ->whereIn('id', $recommendationIds)
            ->get();

        // Predicted Favourites: Most Ordered
        $mostOrdered = \App\Models\Product::withCount('orders')->orderByDesc('orders_count')->take(6)->get();

        // Predicted Favourites: Most Viewed
        $mostViewed = DB::table('products')
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        return view('customer.recommendations', compact('recommendations'));
    }
} 