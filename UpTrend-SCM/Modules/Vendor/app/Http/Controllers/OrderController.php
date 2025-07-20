<?php

namespace Modules\Vendor\App\Http\Controllers;

use Modules\Vendor\App\Models\Order;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\Material;
use Modules\Vendor\App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['supplier', 'items.material']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by supplier
        if ($request->filled('supplier_id') && $request->supplier_id !== 'all') {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('order_date', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        $vendor_suppliers = Supplier::orderBy('name')->get();
        
        // Get status counts for summary
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('vendor::orders.index', compact('orders', 'vendor_suppliers', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendor_suppliers = Supplier::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();
        return view('vendor::orders.create', compact('vendor_suppliers', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:vendor_suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date|after:order_date',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'supplier_id' => $request->supplier_id,
                'order_date' => $request->order_date,
                'expected_delivery' => $request->expected_delivery,
                'shipping_cost' => $request->shipping_cost ?? 0,
                'notes' => $request->notes,
                'shipping_address' => $request->shipping_address,
                'payment_terms' => $request->payment_terms,
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $material = Material::find($item['material_id']);
                $totalPrice = $item['quantity'] * $item['unit_price'];
                $totalAmount += $totalPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'material_id' => $item['material_id'],
                    'material_name' => $material->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                    'unit' => $material->unit,
                    'notes' => $item['notes'] ?? null
                ]);
            }

            $taxAmount = $totalAmount * 0.08; // 8% tax
            $grandTotal = $totalAmount + $order->shipping_cost + $taxAmount;

            $order->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandTotal
            ]);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['supplier', 'items.material']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['supplier', 'items.material']);
        $vendor_suppliers = Supplier::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();
        return view('vendor::orders.edit', compact('order', 'vendor_suppliers', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:pending,approved,shipped,received',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date',
            'actual_delivery' => 'nullable|date',
            'shipping_cost' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid',
            'notes' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'payment_terms' => 'nullable|string',
        ]);

        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,shipped,received'
        ]);

        $order->update([
            'status' => $request->status,
            'actual_delivery' => $request->status === 'received' ? now() : null
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }
}
