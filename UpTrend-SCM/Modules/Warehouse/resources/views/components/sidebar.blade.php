<div id="sidebar"class="sidebar" style="z-index:1000; background:#f8f9fa; height:100vh; position:fixed; left:0; top:0; transiton: left 0.3s">
    <h2 style="padding:1rem;">Navigation</h2>
    <ul style="list-style:none; padding:0;">
        <li><a href="{{ url('/') }}">Welcome</a></li>
        <li><a href="{{ url('/dashboard') }}"> Warehouse Dashboard</a></li>
        <li><a href="{{ url('/inventory') }}">Manage Inventory</a></li>
        <li><a href="{{ url('/inventory/reports') }}">WarehouseReports</a></li>
        <li><a href="{{ url('/profile') }}"> Staff Profile</a></li>
        
        <li><a href="{{ url('warehouse/transfer') }}">Transfer Stocks</a></li>
    </ul>
</div>