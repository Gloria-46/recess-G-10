<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Supplier;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Material::with('supplier');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('subcategory', 'LIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by supplier
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('unit_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('unit_price', '<=', $request->max_price);
        }

        $materials = $query->orderBy('name')->paginate(15);

        // Get unique categories for filter dropdown
        $categories = Material::distinct()->pluck('category')->filter()->values();
        
        // Get suppliers for filter dropdown
        $suppliers = Supplier::orderBy('name')->get();

        return view('materials.index', compact('materials', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('materials.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'lead_time_days' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:available,discontinued,out_of_stock',
            'specifications' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Material::create($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Material created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::with('supplier')->findOrFail($id);
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = Material::findOrFail($id);
        $suppliers = Supplier::orderBy('name')->get();
        return view('materials.edit', compact('material', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'lead_time_days' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:available,discontinued,out_of_stock',
            'specifications' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Material updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Material deleted successfully!');
    }
}
