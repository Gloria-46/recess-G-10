<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockTransferController
{
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,product_id',
        'to_branch' => 'required|string',
        'quantity' => 'required|integer|min:1'
    ]);

    $product = Product::find($request->product_id);

    if ($product->quantity < $request->quantity) {
        return back()->with('error', 'Not enough stock to transfer');
    }

    $product->quantity -= $request->quantity;
    $product->save();

    StockTransfer::create([
        'product_id' => $request->product_id,
        'to_branch' => $request->to_branch,
        'quantity' => $request->quantity,
        'staff_id' => auth()->user()->user_id
    ]);

    return back()->with('success', 'Stock transferred to ' . $request->to_branch);
}

}
