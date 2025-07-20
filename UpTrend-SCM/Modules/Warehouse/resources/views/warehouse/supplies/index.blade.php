@extends('warehouse::layouts.app')

@section('content')
<style>
    .supplies-container {
        max-width: 1200px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(30,58,138,0.08);
        padding: 2.5rem 2rem;
    }
    .supplies-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .supplies-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
    }
    .btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        margin-left: 0.5rem;
    }
    .btn:hover {
        background: #1e3a8a;
    }
    .supplies-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }
    .supplies-table th, .supplies-table td {
        padding: 1rem 0.7rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    .supplies-table th {
        background: #f1f5f9;
        font-size: 1.05rem;
        color: #1e293b;
        font-weight: 600;
    }
    .supplies-table tr:last-child td {
        border-bottom: none;
    }
    .supplies-table td {
        font-size: 1rem;
        color: #374151;
    }
    .supplies-table tr:hover {
        background: #f8fafc;
    }
    .badge {
        display: inline-block;
        padding: 0.3rem 1rem;
        border-radius: 1rem;
        font-size: 0.98rem;
        font-weight: 600;
        color: #fff;
    }
    .badge-received { background: #22c55e; }
    .badge-pending { background: #f59e42; }
    .badge-returned { background: #ef4444; }
</style>
<div class="supplies-container">
    <div class="supplies-header">
        <div class="supplies-title">Supplies Received</div>
        <div>
            <a href="{{ route('supplies.create') }}" class="btn">+ Add Supply</a>
        </div>
    </div>
    <table class="supplies-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Date Received</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $i => $supply)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $supply->supplier->name ?? '-' }}</td>
                <td>{{ $supply->product->name ?? '-' }}</td>
                <td>{{ $supply->quantity }}</td>
                <td>{{ $supply->date_received ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($supply->status) }}">{{ $supply->status }}</span>
                </td>
                <td>
                    <a href="{{ route('supplies.show', $supply) }}" class="btn" style="background:#64748b;">View</a>
                    <a href="{{ route('supplies.edit', $supply) }}" class="btn" style="background:#f59e42; color:#fff;">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 