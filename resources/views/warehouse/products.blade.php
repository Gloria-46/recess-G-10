<x-app-layout>
    <div class="card">
        <h2 class="card-title">All Products</h2>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <div>
                <div style="position: relative; display: inline-block;">
                    <button id="categoryDropdownBtn" style="background: #2563eb; color: #fff; padding: 0.5rem 1.2rem; border-radius: 0.4rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; box-shadow: 0 2px 8px rgba(30,58,138,0.10);">
                        Categories &#9662;
                    </button>
                    <div id="categoryDropdown" style="display: none; position: absolute; left: 0; top: 110%; background: #fff; border-radius: 0.4rem; box-shadow: 0 2px 8px rgba(30,58,138,0.10); min-width: 180px; z-index: 10;">
                        <a href="{{ route('products.ladies') }}" style="display: block; padding: 0.7rem 1.2rem; color: #1e3a8a; text-decoration: none; font-weight: 500;">Ladies</a>
                        <a href="{{ route('products.gentlemen') }}" style="display: block; padding: 0.7rem 1.2rem; color: #1e3a8a; text-decoration: none; font-weight: 500;">Gentlemen</a>
                    </div>
                </div>
            </div>
            <a href="{{ route('products.create') }}" style="background: #2563eb; color: #fff; padding: 0.5rem 1.2rem; border-radius: 0.4rem; font-weight: 600; text-decoration: none; font-size: 1rem; box-shadow: 0 2px 8px rgba(30,58,138,0.10); transition: background 0.2s;">+ Add Product</a>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
            @foreach($products as $product)
                <div class="card" style="width: 340px; min-width: 260px; padding: 1.5rem 1.25rem; box-shadow: 0 2px 8px rgba(30,58,138,0.08);">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 0.75rem;">
                    @else
                        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 0.5rem; margin-bottom: 0.75rem;"></div>
                    @endif
                    <h3 class="card-title" style="font-size: 1.2rem; margin-bottom: 0.5rem;">{{ $product->name }}</h3>
                    <div style="color:#64748b; font-size:0.98rem; margin-bottom:0.5rem;">Category: <b>{{ $product->category ?? '' }}</b></div>
                    <div style="margin-bottom:0.5rem;">Price: <b>UGX {{ $product->price ? number_format($product->price, 0) : 'N/A' }}</b></div>
                    <div style="margin-bottom:0.5rem;">Colors: <b>{{ is_array($product->colors) ? implode(', ', $product->colors) : ($product->colors ?? 'N/A') }}</b></div>
                    <div style="margin-bottom:0.5rem;">Sizes: <b>{{ is_array($product->sizes) ? implode(', ', $product->sizes) : ($product->sizes ?? 'N/A') }}</b></div>
                    <div style="margin-bottom:0.5rem;">Status: <span style="color:{{ $product->status === 'Active' ? '#059669' : '#991b1b' }}; font-weight:600;">{{ $product->status ?? 'N/A' }}</span></div>
                    <div style="display:flex; gap:0.5rem; margin-top:0.5rem;">
                        <a href="{{ route('products.edit', $product->product_id) }}" class="btn-blue" style="background:#22c55e;">Edit</a>
                        <form action="{{ route('products.delete', $product->product_id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-blue" style="background:#991b1b;">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        const btn = document.getElementById('categoryDropdownBtn');
        const dropdown = document.getElementById('categoryDropdown');
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</x-app-layout> 