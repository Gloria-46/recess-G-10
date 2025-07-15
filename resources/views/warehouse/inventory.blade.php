<x-app-layout>
    <x-slot name="header">
        <div class="bg-blue-900 shadow-sm py-8 px-8 flex items-center justify-between rounded-b-lg">
            <h2 class="text-4xl font-extrabold text-white tracking-wide">Inventory</h2>
            <a href="{{ route('supplies.index') }}" style="background: #2563eb; color: #fff; padding: 0.7rem 1.5rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; box-shadow: 0 2px 8px rgba(30,58,138,0.10); transition: background 0.2s; text-decoration: none; margin-left: 1.5rem;">View Supplies</a>
            <a href="{{ route('orders.myRetailerOrders') }}" style="background: #14b8a6; color: #fff; padding: 0.7rem 1.5rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; box-shadow: 0 2px 8px rgba(20,184,166,0.10); transition: background 0.2s; text-decoration: none; margin-left: 1.5rem;">My Retailer Orders</a>
        </div>
    </x-slot>
    <div class="min-h-screen bg-blue-100 py-12">
        <div class="inventory-container">
            <div class="card">
                <h2 class="card-title">Warehouse Inventory</h2>
                @if(session('success'))
                    <div style="background:#d1fae5; color:#065f46; border-radius:0.5rem; padding:0.75rem 1rem; margin-bottom:1rem;">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div style="background:#fee2e2; color:#991b1b; border-radius:0.5rem; padding:0.75rem 1rem; margin-bottom:1rem;">{{ session('error') }}</div>
                @endif
                <div style="overflow-x:auto;">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="min-width: 160px;">Product Name & Description</th>
                                <th style="min-width: 120px;">Category</th>
                                <th style="min-width: 120px;">Batch</th>
                                <th style="min-width: 140px;">Date Stocked</th>
                                <th style="min-width: 120px;">Price (UGX)</th>
                                <th style="min-width: 160px;">Colors Available</th>
                                <th style="min-width: 160px;">Sizes Available</th>
                                <th style="min-width: 100px;">Status</th>
                                <th style="min-width: 140px;">Quantity in Stock</th>
                                <th style="min-width: 160px;">Actions</th>
                                <th style="min-width: 120px;">Reorder Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="inventory-row">
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:48px; height:48px; object-fit:cover; border-radius:0.5rem;">
                                        @else
                                            <div style="width:48px; height:48px; background:#f1f5f9; border-radius:0.5rem;"></div>
                                        @endif
                                    </td>
                                    <td style="font-weight:600;">
                                        {{ $product->name }}
                                        <div style="font-weight:400; color:#64748b; font-size:0.97rem; margin-top:0.2rem;">
                                            {{ $product->description ?? '' }}
                                        </div>
                                    </td>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->batch ?? 'N/A' }}</td>
                                    <td>{{ $product->date ?? ($product->created_at ? $product->created_at->format('Y-m-d H:i') : 'N/A') }}</td>
                                    <td>{{ $product->price ? number_format($product->price, 0) : 'N/A' }}</td>
                                    <td>
                                        @if($product->colors && is_array($product->colors))
                                            {{ implode(', ', $product->colors) }}
                                        @else
                                            {{ $product->colors ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->sizes && is_array($product->sizes))
                                            {{ implode(', ', $product->sizes) }}
                                        @else
                                            {{ $product->sizes ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span style="color:{{ $product->status === 'Active' ? '#059669' : '#991b1b' }}; font-weight:600;">
                                            {{ $product->status ?? 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:column; gap:0.25rem;">
                                            <span style="background:#d1fae5; color:#065f46; border-radius:0.5rem; padding:0.25rem 0.75rem; font-weight:600;">
                                                {{ $product->quantity }} total
                                            </span>
                                            @if($product->stockDetails->count() > 0)
                                                <small style="color:#6b7280; font-size:0.75rem;">
                                                    {{ $product->stockDetails->whereNotNull('color')->count() }} colors, 
                                                    {{ $product->stockDetails->whereNotNull('size')->count() }} sizes
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('warehouse.stock.add', $product->product_id) }}" class="action-btn add-btn">
                                                <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                                Add Stock
                                            </a>
                                            <a href="{{ route('products.edit', $product->product_id) }}" class="action-btn edit-btn">
                                                <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-1.414.94l-4.243 1.415 1.415-4.243a4 4 0 01.94-1.414z" /></svg>
                                                Edit
                                            </a>
                                            <a href="{{ route('warehouse.stock.remove', $product->product_id) }}" class="action-btn remove-btn">
                                                <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                                Remove Stock
                                            </a>
                                            <form action="{{ route('products.delete', $product->product_id) }}" method="POST" class="inline-form" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn">
                                                    <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="background:#fef3c7; color:#92400e; border-radius:0.5rem; padding:0.25rem 0.75rem; font-weight:600;">
                                            {{ $product->reorder_level ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<style>
    /* Inventory Container */
    .inventory-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Inventory Table Styles */
    .inventory-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .inventory-table thead {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
    }

    .inventory-table th {
        padding: 1rem 0.75rem;
        text-align: left;
        font-weight: 600;
        color: white;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #1e3a8a;
    }

    .inventory-table th:first-child {
        border-top-left-radius: 8px;
    }

    .inventory-table th:last-child {
        border-top-right-radius: 8px;
    }

    .inventory-row {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .inventory-row:hover {
        background: #f8fafc;
    }

    .inventory-row:last-child {
        border-bottom: none;
    }

    .inventory-table td {
        padding: 1rem 0.75rem;
        border-right: 1px solid #e5e7eb;
        vertical-align: top;
    }

    .inventory-table td:last-child {
        border-right: none;
    }

            /* Responsive table */
        @media (max-width: 768px) {
            .inventory-container {
                padding: 0 0.5rem;
            }
            
            .inventory-table {
                font-size: 0.75rem;
                min-width: 800px;
            }
            
            .inventory-table th,
            .inventory-table td {
                padding: 0.5rem 0.25rem;
            }
        }

        @media (max-width: 1024px) {
            .inventory-table {
                min-width: 1000px;
            }
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .action-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .small-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }

        /* Add Product Button */
        .add-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }

        /* Edit Button */
        .edit-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
        }

        /* Remove Stock Button */
        .remove-btn {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .remove-btn:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
        }

        /* Delete Button */
        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .inline-form {
            display: inline;
        }

        /* Responsive buttons */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            
            .action-btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.7rem;
            }
            
            .small-icon {
                width: 0.875rem;
                height: 0.875rem;
                margin-right: 0.25rem;
            }
        }
</style>
