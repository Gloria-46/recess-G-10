<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.dashboard');
    }

    public function inventory()
    {
        $products = Product::with('stockDetails')->get();
        return view('warehouse.inventory', compact('products'));
    }

    public function showAddStock($productId)
    {
        $product = Product::findOrFail($productId);
        return view('warehouse.stock.add', compact('product'));
    }

    public function addStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:0',
            'reason' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date|after:today',
            'supplier' => 'nullable|string|max:255',
            'cost_price' => 'nullable|numeric|min:0',
            'color_quantities' => 'nullable|array',
            'size_quantities' => 'nullable|array',
        ], [
            'quantity.min' => 'Quantity must be at least 0.',
        ]);

        // Check if at least one quantity is provided
        $hasGeneralQuantity = $request->quantity && $request->quantity > 0;
        $hasColorQuantities = $request->has('color_quantities') && array_sum($request->color_quantities) > 0;
        $hasSizeQuantities = $request->has('size_quantities') && array_sum($request->size_quantities) > 0;

        if (!$hasGeneralQuantity && !$hasColorQuantities && !$hasSizeQuantities) {
            return back()->with('error', 'Please provide at least one quantity to add.');
        }

        $product = Product::findOrFail($productId);
        $totalQuantity = 0;

        // Process color-based stock additions
        if ($request->has('color_quantities')) {
            foreach ($request->color_quantities as $color => $quantity) {
                if ($quantity > 0) {
                    $stockDetail = \App\Models\ProductStockDetail::firstOrCreate(
                        [
                            'product_id' => $productId,
                            'color' => $color,
                            'size' => null,
                        ],
                        ['quantity' => 0]
                    );
                    $stockDetail->quantity += $quantity;
                    $stockDetail->save();
                    $totalQuantity += $quantity;
                }
            }
        }

        // Process size-based stock additions
        if ($request->has('size_quantities')) {
            foreach ($request->size_quantities as $size => $quantity) {
                if ($quantity > 0) {
                    $stockDetail = \App\Models\ProductStockDetail::firstOrCreate(
                        [
                            'product_id' => $productId,
                            'color' => null,
                            'size' => $size,
                        ],
                        ['quantity' => 0]
                    );
                    $stockDetail->quantity += $quantity;
                    $stockDetail->save();
                    $totalQuantity += $quantity;
                }
            }
        }

        // If no color/size specific quantities, add to general quantity
        if ($totalQuantity == 0) {
            $totalQuantity = $request->quantity;
        }

        // Update main product quantity
        $product->quantity += $totalQuantity;
        $product->save();

        // Log the stock addition
        \App\Models\StockLog::create([
            'product_id' => $productId,
            'action' => 'add',
            'quantity' => $totalQuantity,
            'reason' => $request->reason,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'supplier' => $request->supplier,
            'cost_price' => $request->cost_price,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('warehouse.inventory')->with('success', 'Stock added successfully.');
    }

    public function showRemoveStock($productId)
    {
        $product = Product::findOrFail($productId);
        return view('warehouse.stock.remove', compact('product'));
    }

    public function removeStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:0',
            'reason' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'damaged' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
            'color_quantities' => 'nullable|array',
            'size_quantities' => 'nullable|array',
        ], [
            'quantity.min' => 'Quantity must be at least 0.',
            'reason.required' => 'Please provide a reason for removing stock.',
        ]);

        // Check if at least one quantity is provided
        $hasGeneralQuantity = $request->quantity && $request->quantity > 0;
        $hasColorQuantities = $request->has('color_quantities') && array_sum($request->color_quantities) > 0;
        $hasSizeQuantities = $request->has('size_quantities') && array_sum($request->size_quantities) > 0;

        if (!$hasGeneralQuantity && !$hasColorQuantities && !$hasSizeQuantities) {
            return back()->with('error', 'Please provide at least one quantity to remove.');
        }

        $product = Product::findOrFail($productId);
        $totalQuantity = 0;

        // Process color-based stock removals
        if ($request->has('color_quantities')) {
            foreach ($request->color_quantities as $color => $quantity) {
                if ($quantity > 0) {
                    $stockDetail = \App\Models\ProductStockDetail::where([
                        'product_id' => $productId,
                        'color' => $color,
                        'size' => null,
                    ])->first();

                    if (!$stockDetail || $stockDetail->quantity < $quantity) {
                        return back()->with('error', "Insufficient stock for color: $color");
                    }

                    $stockDetail->quantity -= $quantity;
                    $stockDetail->save();
                    $totalQuantity += $quantity;
                }
            }
        }

        // Process size-based stock removals
        if ($request->has('size_quantities')) {
            foreach ($request->size_quantities as $size => $quantity) {
                if ($quantity > 0) {
                    $stockDetail = \App\Models\ProductStockDetail::where([
                        'product_id' => $productId,
                        'color' => null,
                        'size' => $size,
                    ])->first();

                    if (!$stockDetail || $stockDetail->quantity < $quantity) {
                        return back()->with('error', "Insufficient stock for size: $size");
                    }

                    $stockDetail->quantity -= $quantity;
                    $stockDetail->save();
                    $totalQuantity += $quantity;
                }
            }
        }

        // If no color/size specific quantities, remove from general quantity
        if ($totalQuantity == 0) {
            if ($product->quantity < $request->quantity) {
                return back()->with('error', 'Insufficient stock to remove.');
            }
            $totalQuantity = $request->quantity;
        }

        // Update main product quantity
        $product->quantity -= $totalQuantity;
        $product->save();

        // Log the stock removal
        \App\Models\StockLog::create([
            'product_id' => $productId,
            'action' => 'remove',
            'quantity' => $totalQuantity,
            'reason' => $request->reason,
            'destination' => $request->destination,
            'damaged' => $request->damaged ?? false,
            'notes' => $request->notes,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('warehouse.inventory')->with('success', 'Stock removed successfully.');
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
        // Reorder Report
        $reorderProducts = \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->get();
        
        // Inventory Summary
        $totalProducts = \App\Models\Product::count();
        $activeProducts = \App\Models\Product::where('status', 'Active')->count();
        $inactiveProducts = \App\Models\Product::where('status', 'Inactive')->count();
        $totalStockValue = \App\Models\Product::sum(DB::raw('quantity * price'));
        $totalStockUnits = \App\Models\Product::sum('quantity');
        
        // Category Analysis
        $categoryStats = \App\Models\Product::selectRaw('category, COUNT(*) as count, SUM(quantity) as total_quantity, AVG(price) as avg_price')
            ->groupBy('category')
            ->get();
        
        // Stock Transfer Report
        $recentTransfers = \App\Models\StockTransfer::with('product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Low Stock Products (below 50% of reorder level)
        $criticalStock = \App\Models\Product::whereRaw('quantity < (reorder_level * 0.5)')->get();
        
        // Top Products by Quantity
        $topProducts = \App\Models\Product::orderBy('quantity', 'desc')
            ->limit(10)
            ->get();
        
        // Monthly Stock Movement (last 6 months)
        $monthlyTransfers = \App\Models\StockTransfer::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(quantity) as total_transferred')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        
        return view('warehouse.reports', compact(
            'reorderProducts',
            'totalProducts',
            'activeProducts', 
            'inactiveProducts',
            'totalStockValue',
            'totalStockUnits',
            'categoryStats',
            'recentTransfers',
            'criticalStock',
            'topProducts',
            'monthlyTransfers'
        ));
    }

    public function alerts()
    {
        $lowStockProducts = \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->get();
        $activeProducts = \App\Models\Product::where('status', 'Active')->count();
        $totalProducts = \App\Models\Product::count();
        $totalStock = \App\Models\Product::sum('quantity');
        
        return view('warehouse.alerts', compact('lowStockProducts', 'activeProducts', 'totalProducts', 'totalStock'));
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
            'transfer_date' => 'nullable|date',
            'priority' => 'nullable|in:normal,urgent,express',
            'notes' => 'nullable|string',
            'selected_colors' => 'nullable|array',
            'selected_sizes' => 'nullable|array',
        ]);

        $product = \App\Models\Product::find($request->product_id);
        
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock to transfer.');
        }

        // Calculate total quantity from color and size selections
        $totalSelectedQuantity = 0;
        $colorQuantities = [];
        $sizeQuantities = [];

        // Process color quantities
        if ($request->has('selected_colors')) {
            foreach ($request->selected_colors as $color) {
                $colorQty = $request->input("color_quantity_{$color}", 0);
                if ($colorQty > 0) {
                    $colorQuantities[$color] = $colorQty;
                    $totalSelectedQuantity += $colorQty;
                }
            }
        }

        // Process size quantities
        if ($request->has('selected_sizes')) {
            foreach ($request->selected_sizes as $size) {
                $sizeQty = $request->input("size_quantity_{$size}", 0);
                if ($sizeQty > 0) {
                    $sizeQuantities[$size] = $sizeQty;
                    $totalSelectedQuantity += $sizeQty;
                }
            }
        }

        // If specific quantities are selected, use them; otherwise use the general quantity
        $transferQuantity = $totalSelectedQuantity > 0 ? $totalSelectedQuantity : $request->quantity;

        if ($product->quantity < $transferQuantity) {
            return back()->with('error', 'Insufficient stock to transfer. Available: ' . $product->quantity . ', Requested: ' . $transferQuantity);
        }

        // Update product stock
        $product->quantity -= $transferQuantity;
        $product->save();

        // Create stock transfer record
        $transferData = [
            'product_id' => $request->product_id,
            'to_branch' => $request->to_branch,
            'quantity' => $transferQuantity,
            'staff_id' => Auth::id(),
            'transfer_date' => $request->transfer_date ?? now(),
            'priority' => $request->priority ?? 'normal',
            'notes' => $request->notes,
        ];

        // Add color and size details if available
        if (!empty($colorQuantities)) {
            $transferData['color_details'] = json_encode($colorQuantities);
        }
        if (!empty($sizeQuantities)) {
            $transferData['size_details'] = json_encode($sizeQuantities);
        }

        \App\Models\StockTransfer::create($transferData);

        $successMessage = "Stock transferred successfully to {$request->to_branch}.";
        
        if (!empty($colorQuantities) || !empty($sizeQuantities)) {
            $details = [];
            if (!empty($colorQuantities)) {
                $colorDetails = [];
                foreach ($colorQuantities as $color => $qty) {
                    $colorDetails[] = "{$qty} {$color}";
                }
                $details[] = "Colors: " . implode(', ', $colorDetails);
            }
            if (!empty($sizeQuantities)) {
                $sizeDetails = [];
                foreach ($sizeQuantities as $size => $qty) {
                    $sizeDetails[] = "{$qty} {$size}";
                }
                $details[] = "Sizes: " . implode(', ', $sizeDetails);
            }
            $successMessage .= " Details: " . implode('; ', $details);
        }

        return back()->with('success', $successMessage);
    }

    public function transfersIndex()
    {
        $transfers = \App\Models\StockTransfer::orderByDesc('created_at')->get();
        return view('warehouse.transfers.index', compact('transfers'));
    }

    public function products()
    {
        $products = \App\Models\Product::all();
        return view('warehouse.products', compact('products'));
    }

    public function productsLadies()
    {
        $products = \App\Models\Product::where('category', 'Ladies')->get();
        return view('warehouse.products_ladies', compact('products'));
    }

    public function productsGentlemen()
    {
        $products = \App\Models\Product::where('category', 'Gentlemen')->get();
        return view('warehouse.products_gentlemen', compact('products'));
    }

    public function editProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('warehouse.edit_product', compact('product'));
    }

    public function deleteProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->quantity = $request->input('quantity');
        // Sanitize price to ensure only numeric value is saved
        $price = preg_replace('/[^0-9]/', '', $request->input('price'));
        $product->price = $price;
        $product->colors = $request->input('colors');
        $product->sizes = $request->input('sizes');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->save();
        return redirect()->route('warehouse.inventory')->with('success', 'Product updated successfully.');
    }

    public function updateProductAjax(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $fields = $request->only(['name', 'category', 'quantity', 'price', 'colors', 'sizes', 'status', 'description']);
        foreach ($fields as $key => $value) {
            if ($key === 'price') {
                $value = preg_replace('/[^0-9]/', '', $value);
            }
            $product->$key = $value;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->save();
        return response()->json(['success' => true, 'message' => 'Product auto-saved successfully.']);
    }

    public function createProduct()
    {
        return view('warehouse.create_product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'nullable|date',
            'quantity' => 'required|integer',
        ]);

        $product = new \App\Models\Product();
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->date = $request->input('date');
        $product->quantity = $request->input('quantity');
        // Sanitize price to ensure only numeric value is saved
        $price = preg_replace('/[^0-9]/', '', $request->input('price'));
        $product->price = $price;
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->colors = $request->input('colors');
        $product->sizes = $request->input('sizes');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->save();

        // Generate batch number: BATCH-<ID>-<YEAR>
        $product->batch = 'BATCH-' . str_pad($product->product_id, 3, '0', STR_PAD_LEFT) . '-' . date('Y');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
}

