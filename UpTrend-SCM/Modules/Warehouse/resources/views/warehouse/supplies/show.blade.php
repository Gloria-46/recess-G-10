@extends('warehouse::layouts.app')

@section('content')
<style>
    .supply-details-container {
        max-width: 600px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(30,58,138,0.08);
        padding: 2.5rem 2rem;
    }
    .supply-details-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 2rem;
        text-align: center;
    }
    .details-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.2rem;
    }
    .details-label {
        font-weight: 600;
        color: #1e293b;
    }
    .details-value {
        color: #374151;
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
    .back-btn {
        display: inline-block;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        margin-top: 2rem;
    }
    .back-btn:hover {
        background: #1e3a8a;
    }
</style>
<div class="supply-details-container">
    <div class="supply-details-title">Supply Details</div>
    <div class="details-row">
        <span class="details-label">Supplier:</span>
        <span class="details-value">{{ $supply->supplier->name ?? '-' }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Product:</span>
        <span class="details-value">{{ $supply->product->name ?? '-' }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Quantity:</span>
        <span class="details-value">{{ $supply->quantity }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Date Received:</span>
        <span class="details-value">{{ $supply->date_received ?? '-' }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Status:</span>
        <span class="details-value">
            <span class="badge badge-{{ strtolower($supply->status) }}">{{ $supply->status }}</span>
        </span>
    </div>
    <div class="details-row">
        <span class="details-label">Notes:</span>
        <span class="details-value">{{ $supply->notes ?? '-' }}</span>
    </div>
    <a href="{{ route('supplies.index') }}" class="back-btn">&larr; Back to Supplies</a>
</div>
@endsection 