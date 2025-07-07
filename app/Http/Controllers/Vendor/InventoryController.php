<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductBatch;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewStockAdded;

class InventoryController extends Controller
{
    public function index()
    {
        $vendorId = Auth::guard('vendor')->id();
        $products = Product::where('vendor_id', $vendorId)->get();
        $batches = ProductBatch::whereIn('product_id', $products->pluck('id'))
            ->with('product')
            ->orderBy('product_id')
            ->orderBy('received_at')
            ->get();

        // Calculate running stock for each batch
        $runningStocks = [];
        $batchRows = [];
        foreach ($batches as $batch) {
            $pid = $batch->product_id;
            if (!isset($runningStocks[$pid])) {
                $runningStocks[$pid] = 0;
            }
            $runningStocks[$pid] += $batch->quantity_added;
            $batchRows[] = [
                'id' => $batch->id,
                'product_name' => $batch->product->name,
                'product_image' => $batch->product->image,
                'batch_no' => $batch->batch_no,
                'supplier_name' => $batch->supplier_name,
                'received_at' => $batch->received_at,
                'quantity_added' => $batch->quantity_added,
                'running_stock' => $runningStocks[$pid],
            ];
        }

        $low_stock_inventories = $products->filter(function ($product) {
            return ($product->current_stock ?? 0) <= 5;
        });
        return view('vendor.inventory', [
            'batches' => $batchRows,
            'low_stock_inventories' => $low_stock_inventories,
            'products' => $products,
        ]);
    }

    public function addStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($productId);
        $batchNo = 'BATCH-' . $product->id . '-' . now()->format('YmdHis');
        $batch = ProductBatch::create([
            'product_id' => $product->id,
            'batch_no' => $batchNo,
            'quantity_added' => $request->quantity,
            'received_at' => now(),
        ]);
        $product->current_stock = ($product->current_stock ?? 0) + $request->quantity;
        $product->save();
        // Notify the vendor
        $vendor = auth('vendor')->user();
        if ($vendor) {
            $vendor->notify(new NewStockAdded($product, $batch));
        }
        return redirect()->back()->with('success', 'New stock added successfully!');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_name' => 'nullable|string|max:255',
            'batch_no' => 'required|string|max:255',
            'quantity_added' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Create new batch
        $batch = ProductBatch::create([
            'product_id' => $product->id,
            'batch_no' => $request->batch_no,
            'supplier_name' => $request->supplier_name,
            'quantity_added' => $request->quantity_added,
            'received_at' => now(),
        ]);
        
        // Update product stock
        $product->current_stock = ($product->current_stock ?? 0) + $request->quantity_added;
        $product->save();
        
        // Notify the vendor
        $vendor = auth('vendor')->user();
        if ($vendor) {
            $vendor->notify(new NewStockAdded($product, $batch));
        }
        
        return redirect()->route('vendor.inventory')->with('success', 'Inventory added successfully!');
    }

    public function editBatch($batchId)
    {
        $batch = ProductBatch::with('product')->findOrFail($batchId);
        return view('vendor.edit_batch', [
            'batch' => $batch,
        ]);
    }

    public function updateBatch(Request $request, $batchId)
    {
        $batch = ProductBatch::findOrFail($batchId);
        $request->validate([
            'batch_no' => 'required|string|max:255',
            'supplier_name' => 'nullable|string|max:255',
            'quantity_added' => 'required|integer|min:1',
        ]);
        // Adjust product stock if quantity changes
        $product = $batch->product;
        $oldQty = $batch->quantity_added;
        $newQty = $request->quantity_added;
        $batch->batch_no = $request->batch_no;
        $batch->supplier_name = $request->supplier_name;
        $batch->quantity_added = $newQty;
        $batch->save();
        if ($product) {
            $product->current_stock = ($product->current_stock - $oldQty) + $newQty;
            $product->save();
        }
        return redirect()->route('vendor.inventory')->with('success', 'Batch updated successfully!');
    }

    public function deleteBatch($batchId)
    {
        $batch = ProductBatch::findOrFail($batchId);
        $product = $batch->product;
        if ($product) {
            $product->current_stock = max(0, $product->current_stock - $batch->quantity_added);
            $product->save();
        }
        $batch->delete();
        return redirect()->route('vendor.inventory')->with('success', 'Batch deleted successfully!');
    }

    public function addForm()
    {
        $vendorId = Auth::guard('vendor')->id();
        $products = Product::where('vendor_id', $vendorId)->get();
        return view('vendor.add_inventory', [
            'products' => $products,
        ]);
    }
} 