@extends('warehouse::layouts.app')

@section('content')
<style>
    .transfers-container {
        max-width: 1200px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(30,58,138,0.08);
        padding: 2.5rem 2rem;
    }
    .transfers-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .transfers-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
    }
    .status-badge {
        display: inline-block;
        padding: 0.3rem 1rem;
        border-radius: 1rem;
        font-size: 0.98rem;
        font-weight: 600;
        color: #fff;
    }
    .status-pending { background: #f59e42; }
    .status-delivered { background: #22c55e; }
    .status-notdelivered { background: #ef4444; }
    .transfers-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }
    .transfers-table th, .transfers-table td {
        padding: 1rem 0.7rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    .transfers-table th {
        background: #f1f5f9;
        font-size: 1.05rem;
        color: #1e293b;
        font-weight: 600;
    }
    .transfers-table tr:last-child td {
        border-bottom: none;
    }
    .transfers-table td {
        font-size: 1rem;
        color: #374151;
    }
    .transfers-table tr:hover {
        background: #f8fafc;
    }
    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    .filter-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .filter-btn.active, .filter-btn:hover {
        background: #1e3a8a;
    }
</style>
<div class="transfers-container">
    <div class="transfers-header">
        <div class="transfers-title">All Stock Transfers</div>
        <div class="filter-group">
            <button class="filter-btn active" onclick="filterTransfers('all')">All</button>
            <button class="filter-btn" onclick="filterTransfers('pending')">Pending</button>
            <button class="filter-btn" onclick="filterTransfers('delivered')">Delivered</button>
            <button class="filter-btn" onclick="filterTransfers('notdelivered')">Not Delivered</button>
        </div>
    </div>
    <table class="transfers-table" id="transfersTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>To Branch</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $i => $transfer)
            <tr data-status="{{ strtolower(str_replace(' ', '', $transfer->status)) }}">
                <td>{{ $i+1 }}</td>
                <td>{{ $transfer->product->name ?? '-' }}</td>
                <td>{{ $transfer->to_branch }}</td>
                <td>{{ $transfer->quantity }}</td>
                <td>{{ $transfer->transfer_date ? \Carbon\Carbon::parse($transfer->transfer_date)->format('Y-m-d H:i') : '-' }}</td>
                <td>
                    @php
                        $status = strtolower(str_replace(' ', '', $transfer->status));
                        $badgeClass = $status === 'pending' ? 'status-badge status-pending' : ($status === 'delivered' ? 'status-badge status-delivered' : 'status-badge status-notdelivered');
                    @endphp
                    <span class="{{ $badgeClass }}">{{ ucfirst($transfer->status) }}</span>
                </td>
                <td>{{ $transfer->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
function filterTransfers(status) {
    const rows = document.querySelectorAll('#transfersTable tbody tr');
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector('.filter-btn[onclick*="' + status + '"]').classList.add('active');
    rows.forEach(row => {
        if (status === 'all' || row.getAttribute('data-status') === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection 