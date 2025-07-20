<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Modules\CustomerRetail\App\Models\Product;
use Modules\CustomerRetail\App\Models\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::where('retailer_id', Auth::guard('retailer')->id())
            ->latest()
            ->paginate(10);

        return view('customerretail::retailer.products.index', compact('products'));
    }

    public function create()
    {
        return view('customerretail::retailer.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'color' => 'required|string',
            'size' => 'required|string',
            'image' => 'nullable|image',
            'current_stock' => 'nullable|integer',
            'is_active' => 'boolean',
            'category' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['retailer_id'] = Auth::guard('retailer')->id();
        $validated['is_active'] = true;

        $product = Product::create([
            'retailer_id' => Auth::guard('retailer')->id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'color' => $validated['color'] ?? null,
            'size' => $validated['size'] ?? null,
            'image' => $path ?? null,
            'current_stock' => $validated['current_stock'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'category' => $validated['category'] ?? null,
        ]);

        return redirect()->route('retailer.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return view('customerretail::retailer.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('customerretail::retailer.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'color' => 'required|string',
            'size' => 'required|string',
            'image' => 'nullable|image',
            'current_stock' => 'nullable|integer',
            'is_active' => 'boolean',
            'category' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'color' => $validated['color'] ?? null,
            'size' => $validated['size'] ?? null,
            'image' => $path ?? $product->image,
            'current_stock' => $validated['current_stock'] ?? $product->current_stock,
            'is_active' => $validated['is_active'] ?? $product->is_active,
            'category' => $validated['category'] ?? $product->category,
        ]);

        return redirect()->route('retailer.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('retailer.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
