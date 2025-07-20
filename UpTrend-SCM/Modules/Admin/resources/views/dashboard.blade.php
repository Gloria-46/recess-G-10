@php use Illuminate\Support\Str; @endphp
<x-app-layout> 
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, Welcome Back {{ Str::of($user->name)->explode(' ')->first() }}!</h3>
                            <p class="mb-0">Get started!</p>
                        </div>
                        <button type="button"
                            class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                            <span class="btn-inner--icon">
                                <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                    <span class="visually-hidden">New</span>
                                </span>
                            </span>
                            <a href="{{ route('admin.chat.index') }}"><span class="btn-inner--text">Messages</span></a>
                        </button>
                        {{-- <a href="{{ route('') }}">
                            Chat <span class="badge bg-danger">{{ auth()->user()->unreadMessages()->count() }}</span>
                        </a> --}}

                        {{-- <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                            <span class="btn-inner--icon">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </span>
                            <span class="btn-inner--text">Sync</span>
                        </button> --}}
                    {{-- </div> --}}
                </div>
            </div>
            <hr class="my-0">
            <div class="row">
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">
                            @if($retailBestSellingProducts->count() > 0)
                                @foreach($retailBestSellingProducts as $i => $product)
                            <div class="swiper-slide">
                                <div>
                                        <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                            <div class="full-background bg-cover" style="background-image: url('{{ asset($product->image) }}')"></div>
                                        <div class="card-body text-start px-3 py-0 w-100">
                                            <div class="row mt-12">
                                                <div class="col-sm-3 mt-auto">
                                                        <h4 class="text-dark font-weight-bolder">#{{ $i+1 }}</h4>
                                                        <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                        <h5 class="text-dark font-weight-bolder">{{ $product->name }}</h5>
                                                </div>
                                                <div class="col-sm-3 ms-auto mt-auto">
                                                        <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category</p>
                                                        <h5 class="text-dark font-weight-bolder">{{ $product->category }}</h5>
                                                        <span class="badge bg-success">Sold: {{ $product->total_sold }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="swiper-slide">
                                    <div>
                                        <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                            <div class="full-background bg-cover" style="background-image: url('../assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                                    <div class="col-sm-6 mt-auto">
                                                        <h4 class="text-dark font-weight-bolder">No Products Yet</h4>
                                                        <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Best selling products will appear here once you have sales data</p>
                                                        <h5 class="text-dark font-weight-bolder">Start selling to see your top products!</h5>
                                </div>
                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            {{-- ================= Warehouse Section ================= --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"><h4>Warehouse</h4></div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card"><div class="card-body"><h6>Total Products</h6><p>{{ $warehouseProductCount }}</p></div></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card"><div class="card-body">
                                        <h6>Stock Levels</h6>
                                        <table class="table"><thead><tr><th>Product</th><th>Stock</th></tr></thead><tbody>
                                            @foreach($warehouseProducts as $p)
                                            <tr><td>{{ $p->name }}</td><td>{{ $p->quantity }}</td></tr>
                                            @endforeach
                                        </tbody></table>
                                    </div></div>
                                </div>
                            </div>
                            <h6>Recent Orders</h6>
                            <table class="table"><thead><tr><th>Order #</th><th>Date</th><th>Total</th></tr></thead><tbody>
                                @foreach($warehouseOrders as $o)
                                <tr><td>{{ $o->order_number }}</td><td>{{ $o->created_at->format('Y-m-d') }}</td><td>{{ $o->total }}</td></tr>
                                @endforeach
                            </tbody></table>
                            <h6>Quarterly Sales</h6>
                            <canvas id="warehouseQuarterlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================= Vendor Section ================= --}}
            <div class="row mt-4">
                                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"><h4>Vendor</h4></div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card"><div class="card-body"><h6>Total Products</h6><p>{{ $vendorProductCount }}</p></div></div>
                                        </div>
                                <div class="col-md-8">
                                    <div class="card"><div class="card-body">
                                        <h6>Stock Levels</h6>
                                        <table class="table"><thead><tr><th>Product</th><th>Stock</th></tr></thead><tbody>
                                            @foreach($vendorProducts as $p)
                                            <tr><td>{{ $p->name }}</td><td>{{ $p->quantity }}</td></tr>
                                            @endforeach
                                        </tbody></table>
                                    </div></div>
                                </div>
                            </div>
                            <h6>Recent Orders</h6>
                            <table class="table"><thead><tr><th>Order #</th><th>Date</th><th>Total</th></tr></thead><tbody>
                                @foreach($vendorOrders as $o)
                                <tr><td>{{ $o->order_number }}</td><td>{{ $o->created_at->format('Y-m-d') }}</td><td>{{ $o->grand_total }}</td></tr>
                                @endforeach
                            </tbody></table>
                            <h6>Quarterly Sales</h6>
                            <canvas id="vendorQuarterlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
                            </div>
            {{-- ================= CustomerRetail Section ================= --}}
            <div class="row mt-4">
                                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"><h4>Customer Retail</h4></div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card"><div class="card-body"><h6>Total Products</h6><p>{{ $retailProductCount }}</p></div></div>
                                        </div>
                                <div class="col-md-8">
                                    <div class="card"><div class="card-body">
                                        <h6>Stock Levels</h6>
                                        <table class="table"><thead><tr><th>Product</th><th>Stock</th></tr></thead><tbody>
                                            @foreach($retailProducts as $p)
                                            <tr><td>{{ $p->name }}</td><td>{{ $p->current_stock }}</td></tr>
                                            @endforeach
                                        </tbody></table>
                                    </div></div>
                                </div>
                            </div>
                            <h6>Recent Orders</h6>
                            <table class="table"><thead><tr><th>Order #</th><th>Date</th><th>Total</th></tr></thead><tbody>
                                @foreach($retailOrders as $o)
                                <tr><td>{{ $o->order_number }}</td><td>{{ $o->created_at->format('Y-m-d') }}</td><td>{{ $o->total_amount }}</td></tr>
                                @endforeach
                            </tbody></table>
                            <h6>Quarterly Sales</h6>
                            <canvas id="retailQuarterlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
                            </div>
            {{-- ================= Featured Retail Products ================= --}}
            <div class="row mt-4">
                                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"><h4>Featured Retail Products</h4></div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card"><div class="card-body"><h6>Total Products</h6><p>{{ $retailFeaturedProductCount }}</p></div></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card"><div class="card-body">
                                        <h6>Products</h6>
                                        <div class="row">
                                            @foreach($retailFeaturedProducts as $product)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:120px;object-fit:cover;">
                                                    <div class="card-body p-2">
                                                        <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                                        <p class="card-text text-muted mb-0" style="font-size:0.9em;">{{ $product->category }}</p>
                            </div>
                        </div>
                    </div>
                                            @endforeach
                                        </div>
                                    </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================= Charts Script ================= --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Warehouse
                const warehouseLabels = @json($warehouseQuarterlySales->map(fn($q) => 'Q'.$q->quarter.' '.$q->year));
                const warehouseData = @json($warehouseQuarterlySales->map(fn($q) => $q->total));
                new Chart(document.getElementById('warehouseQuarterlySalesChart').getContext('2d'), {
                    type: 'bar', data: { labels: warehouseLabels.reverse(), datasets: [{ label: 'Sales', data: warehouseData.reverse(), backgroundColor: 'rgba(54,162,235,0.7)' }] }
                });
                // Vendor
                const vendorLabels = @json($vendorQuarterlySales->map(fn($q) => 'Q'.$q->quarter.' '.$q->year));
                const vendorData = @json($vendorQuarterlySales->map(fn($q) => $q->total));
                new Chart(document.getElementById('vendorQuarterlySalesChart').getContext('2d'), {
                    type: 'bar', data: { labels: vendorLabels.reverse(), datasets: [{ label: 'Sales', data: vendorData.reverse(), backgroundColor: 'rgba(255,99,132,0.7)' }] }
                });
                // CustomerRetail
                const retailLabels = @json($retailQuarterlySales->map(fn($q) => 'Q'.$q->quarter.' '.$q->year));
                const retailData = @json($retailQuarterlySales->map(fn($q) => $q->total));
                new Chart(document.getElementById('retailQuarterlySalesChart').getContext('2d'), {
                    type: 'bar', data: { labels: retailLabels.reverse(), datasets: [{ label: 'Sales', data: retailData.reverse(), backgroundColor: 'rgba(75,192,192,0.7)' }] }
                });
            </script>
            {{-- Swiper Initialization --}}
            <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
            <script>
                var swiper = new Swiper(".mySwiper", {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
            </script>
            {{-- 6 Best Selling Retail Products --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0"><h4>Best Selling Retail Products</h4></div>
                        <div class="card-body">
            <div class="row">
                                @foreach($retailBestSellingProducts as $product)
                                    <div class="col-md-2 mb-3">
                                        <div class="card h-100">
                                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:120px;object-fit:cover;">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                                <p class="card-text text-muted mb-0" style="font-size:0.9em;">{{ $product->category }}</p>
                                                <span class="badge bg-success">Sold: {{ $product->total_sold }}</span>
                                </div>
                                </div>
                            </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-app.footer />
        </div>
 </main> 
</x-app-layout>
{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>UpTrend | Adnimistrator Dashboard </title>
    @vite('resources/css/style.css')
</head>
<body>
    <div class="sidebar">

        <ul>
            <li>Dashboard</li>
            <li>Staff</li>
            <li>Product</li>
            <li>Report</li>

        </ul>
    </div>
</body>
</html> --}}

