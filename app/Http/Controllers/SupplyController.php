<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::with(['supplier', 'product'])->orderByDesc('created_at')->get();
        return view('warehouse.supplies.index', compact('supplies'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('warehouse.supplies.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'date_received' => 'nullable|date',
            'status' => 'required|in:Received,Pending,Returned',
            'notes' => 'nullable|string',
        ]);
        Supply::create($request->all());
        return redirect()->route('supplies.index')->with('success', 'Supply added successfully.');
    }

    public function show(Supply $supply)
    {
        $supply->load(['supplier', 'product']);
        return view('warehouse.supplies.show', compact('supply'));
    }

    public function edit(Supply $supply)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('warehouse.supplies.edit', compact('supply', 'suppliers', 'products'));
    }

    public function update(Request $request, Supply $supply)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'date_received' => 'nullable|date',
            'status' => 'required|in:Received,Pending,Returned',
            'notes' => 'nullable|string',
        ]);
        $supply->update($request->all());
        return redirect()->route('supplies.index')->with('success', 'Supply updated successfully.');
    }

    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect()->route('supplies.index')->with('success', 'Supply deleted successfully.');
    }
} 