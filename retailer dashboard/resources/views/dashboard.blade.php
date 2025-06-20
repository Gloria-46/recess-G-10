<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Uptrend Clothing Store - </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true' || 
              (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: true,
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" :class="{ 'dark': darkMode }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-200 dark:bg-gray-800 shadow-lg" :class="{ '-translate-x-full': !sidebarOpen }">
            <div class="p-4">
                <div class="flex items-center justify-center w-full mb-8 border-b border-gray-300 dark:border-gray-700 pb-4">
                    <i class="fas fa-tshirt text-2xl text-gray-900 dark:text-white"></i>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white ml-2">Uptrend Clothing Store</h1>
                </div>
                
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-2 px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-home"></i>
                        <span>CUSTOMER ORDER</span>
                    </a>

                    <a href="#" class="flex items-center space-x-2 px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-box"></i>
                        <span>WAREHOUSE INVENTORY</span>
                    </a>

                    <a href="/shipments" class="flex items-center space-x-2 px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-truck"></i>
                        <span>Shipments</span>

                    </a>
                    <a href="#" class="flex items-center space-x-2 px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-chart-bar"></i>
                        <span>SALES</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <nav class="bg-white dark:bg-slate-800 shadow-lg">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex justify-between h-16">
                        <!-- Left side -->
                        <div class="flex items-center">
                            <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 focus:outline-none transition-colors duration-200">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 focus:outline-none transition-colors duration-200">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-rose-500"></span>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 z-50">
                                    <div class="px-4 py-2 border-b border-slate-200 dark:border-slate-700">
                                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Notifications</h3>
                                    </div>
                                    <div class="max-h-60 overflow-y-auto">
                                        <!-- Low Stock Alert -->
                                        <a href="#" class="block px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-exclamation-triangle text-amber-500"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-slate-900 dark:text-white">Low Stock Alert</p>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">2 items are below reorder point</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- Shipment Delay -->
                                        <a href="#" class="block px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-truck text-rose-500"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-slate-900 dark:text-white">Shipment Delay</p>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">TRK-003-2024 is delayed</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg transform transition-all duration-200 hover:scale-105">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-teal-500 rounded-md p-3">
                                    <i class="fas fa-box text-white text-2xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Total Inventory Items</dt>
                                        <dd class="text-3xl font-semibold text-slate-900 dark:text-gray">{{ $inventory->count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg transform transition-all duration-200 hover:scale-105">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-rose-500 rounded-md p-3">
                                    <i class="fas fa-truck text-white text-2xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Active Shipments</dt>
                                        <dd class="text-3xl font-semibold text-slate-900 dark:text-white">{{ $shipments->where('status', 'in_transit')->count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg transform transition-all duration-200 hover:scale-105">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-amber-500 rounded-md p-3">
                                    <i class="fas fa-industry text-white text-2xl"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Active Suppliers</dt>
                                        <dd class="text-3xl font-semibold text-slate-900 dark:text-white">{{ $suppliers->where('status', 'active')->count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Shipments -->
                <div class="bg-white dark:bg-slate-800 shadow rounded-lg mb-6 transform transition-all duration-200 hover:shadow-xl">
                    <div class="px-4 py-5 sm:px-6">
                        <h4 class="text-lg leading-6 font-medium text-slate-900 dark:text-white">Recent Shipments</h4>
                    </div>
                    <div class="border-t border-slate-200 dark:border-slate-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-slate-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Tracking #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Supplier</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Est. Delivery</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                    @foreach($shipments->take(5) as $shipment)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $shipment->tracking_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $shipment->supplier->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($shipment->status === 'delivered') bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200
                                                @elseif($shipment->status === 'in_transit') bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200
                                                @elseif($shipment->status === 'delayed') bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200
                                                @else bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200
                                                @endif">
                                                {{ ucfirst($shipment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $shipment->estimated_delivery }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Items -->
                <div class="bg-white dark:bg-slate-800 shadow rounded-lg transform transition-all duration-200 hover:shadow-xl">
                    <div class="px-4 py-5 sm:px-6">
                        <h5 class="text-lg leading-6 font-medium text-slate-900 dark:text-white">Low Stock Items</h5>
                    </div>
                    <div class="border-t border-slate-200 dark:border-slate-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-slate-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">SKU</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">Reorder Point</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                    @foreach($inventory->where('status', 'low_stock')->take(5) as $item)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $item->sku }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">{{ $item->reorder_point }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
