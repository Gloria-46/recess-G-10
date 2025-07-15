<nav class="navbar">
    <!-- Left: Logo/App Name -->
    <div class="flex items-center space-x-3">
        <span class="font-extrabold text-2xl tracking-wide">UPTREND CLOTHING</span>
    </div>
    <!-- Center: Navigation Links -->
    <div class="flex space-x-8 mx-auto w-full justify-center">
        <a href="/" class="nav-link">Welcome</a>
        <a href="/dashboard" class="nav-link">Dashboard</a>
        <a href="/inventory" class="nav-link">Inventory</a>
        <a href="/warehouse/reports" class="nav-link">Reports</a>
        <a href="/warehouse/transfer" class="nav-link">Transfer Stocks</a>
        <a href="/products" class="nav-link">Products</a>
        <a href="/orders/create" class="nav-link">Order</a>
        
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 1.5em; height: 1.5em; vertical-align: middle;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 00-6 6v3.75a6 6 0 006 6h.75a6 6 0 006-6V9.75a6 6 0 00-6-6h-.75zM12 10.5a.75.75 0 000 1.5.75.75 0 000-1.5z" />
            </svg>
            @if(\App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->count() > 0)
                <span class="notification-badge">{{ \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->count() }}</span>
            @endif
        </a>
    </div>
    <!-- Right: User Info and Icons -->
    <div class="flex items-center space-x-4">
        <span class="font-semibold hidden md:inline">Hello, {{ Auth::user()->name ?? 'User' }}</span>
        <a href="/profile" class="nav-link profile-icon" title="Staff Profile">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 1.5em; height: 1.5em; vertical-align: middle;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
        <a href="/alerts" class="nav-link notification-icon" title="Notifications">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 1.5em; height: 1.5em; vertical-align: middle;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            @if(\App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->count() > 0)
                <span class="notification-badge">{{ \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->count() }}</span>
            @endif
        </a>
        <a href="/logout" class="nav-link">Logout</a>
    </div>
</nav>
<style>
.navbar {
  background: #2825eb;
  color: #fff;
  padding: 1.25rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 8px rgba(30,58,138,0.08);
  border-radius: 0 0 1rem 1rem;
}
.nav-link {
  color: #fff;
  font-weight: 600;
  text-decoration: none;
  margin: 0 1rem;
  transition: color 0.2s;
  position: relative;
}
.nav-link:hover {
  color: #a5b4fc;
}
.profile-icon[title]:hover:after,
.notification-icon[title]:hover:after,
.alerts-link[title]:hover:after {
  content: attr(title);
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  bottom: -2.2em;
  background: #05154b;
  color: #fff;
  padding: 0.3em 0.8em;
  border-radius: 0.5em;
  white-space: nowrap;
  font-size: 0.95em;
  z-index: 10;
  pointer-events: none;
}
.notification-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background: #ef4444;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  font-size: 0.75rem;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
  }
  70% {
    box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
  }
}
</style> 