<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\Auth;


class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.dashboard');
    }

    public function inventory()
    {
        $products = Product::all();
        return view('warehouse.inventory', compact('products'));
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $product->quantity += $request->quantity;
        $product->save();

        return back()->with('success', 'Stock added successfully.');
    }

    public function removeStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock to remove.');
        }

        $product->quantity -= $request->quantity;
        $product->save();

        return back()->with('success', 'Stock removed successfully.');
    }

    public function transferStock(Request $request){
        $request->validate([
            'product_id' =>
            'required|
            exists:products,product_id',
            'to_branch' => 'required|string',
            'to quantity' =>'required|integer|min:1',
        ]);
        $product =
        Product::find($request->product_id);
        if ($product->quantity < $request->quantity){
            return
            back()->with('error','Insufficient stock to transfer.');
        }
        $product->quantity =
        $request->quantity;
        $product->save();
        \App\Models\Stocktransfer::create([
            'product_id' =>
            $request->product_id,
            'to_branch' =>
            $request->to_branch,
            'quantity' =>
            $request->quantity,
            'staff_id' =>Auth::id(),
        ]);
        return
        back()->with('success','Stock transferred successfully.');
    }

    public function reports(){
        $reorderProducts = \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->get();
        return view('warehouse.reports', compact('reorderProducts'));
    }

    public function showTransferForm()
    {
        $products = \App\Models\Product::all();
        $branches = ['Kampala', 'Jinja', 'Arua'];
        return view('warehouse.transfer', compact('products', 'branches'));
    }

    public function handleTransfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'to_branch' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = \App\Models\Product::find($request->product_id);
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock to transfer.');
        }
        $product->quantity -= $request->quantity;
        $product->save();
        \App\Models\StockTransfer::create([
            'product_id' => $request->product_id,
            'to_branch' => $request->to_branch,
            'quantity' => $request->quantity,
            'staff_id' => \Auth::id(),
        ]);
        return back()->with('success', 'Stock transferred successfully.');
    }
}

