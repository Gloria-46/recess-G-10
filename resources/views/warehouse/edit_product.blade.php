<x-app-layout>
    <div class="card" style="max-width: 500px; margin: 2rem auto;">
        <h2 class="card-title">Edit Product</h2>
        <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1rem;">
                <label for="name" style="font-weight:600; color:#1e3a8a;">Name</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="category" style="font-weight:600; color:#1e3a8a;">Category</label>
                <select name="category" id="category" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    <option value="ladies" {{ $product->category == 'ladies' ? 'selected' : '' }}>Ladies</option>
                    <option value="gentlemen" {{ $product->category == 'gentlemen' ? 'selected' : '' }}>Gentlemen</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="colors" style="font-weight:600; color:#1e3a8a;">Colors</label>
                <select name="colors[]" id="colors" multiple style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    @php
                        $colorOptions = ['Black','White','Blue','Red','Green','Yellow','Grey','Cream','Pink','Orange','Brown'];
                        $selectedColors = is_array($product->colors) ? $product->colors : ( ($product->colors && !is_array($product->colors) && strpos($product->colors, ',') !== false) ? explode(',', $product->colors) : (array)($product->colors ?? []) );
                    @endphp
                    @foreach($colorOptions as $color)
                        <option value="{{ $color }}" {{ in_array($color, $selectedColors) ? 'selected' : '' }}>{{ $color }}</option>
                    @endforeach
                </select>
                <small>Hold Ctrl (Cmd on Mac) to select multiple colors</small>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="sizes" style="font-weight:600; color:#1e3a8a;">Sizes</label>
                <select name="sizes[]" id="sizes" multiple style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    @php
                        $sizeOptions = ['S','M','L','XL','XXL','28','30','32','34','36','38','40'];
                        $selectedSizes = is_array($product->sizes) ? $product->sizes : ( ($product->sizes && !is_array($product->sizes) && strpos($product->sizes, ',') !== false) ? explode(',', $product->sizes) : (array)($product->sizes ?? []) );
                    @endphp
                    @foreach($sizeOptions as $size)
                        <option value="{{ $size }}" {{ in_array($size, $selectedSizes) ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
                <small>Hold Ctrl (Cmd on Mac) to select multiple sizes</small>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="quantity" style="font-weight:600; color:#1e3a8a;">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="price" style="font-weight:600; color:#1e3a8a;">Price</label>
                <div style="display:flex;align-items:center;">
                    <span style="margin-right:0.5rem; color:#2563eb; font-weight:600;">UGX</span>
                    <input type="text" name="price" id="price" value="{{ $product->price }}" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                </div>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="status" style="font-weight:600; color:#1e3a8a;">Status</label>
                <select name="status" id="status" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="description" style="font-weight:600; color:#1e3a8a;">Description</label>
                <textarea name="description" id="description" rows="3" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">{{ old('description', $product->description) }}</textarea>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="image" style="font-weight:600; color:#1e3a8a;">Image</label><br>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:60px; height:60px; object-fit:cover; border-radius:0.5rem; margin-bottom:0.5rem;">
                @endif
                <input type="file" name="image" id="image" style="width:100%;">
            </div>
            <button type="submit" class="btn-blue">Update Product</button>
        </form>
    </div>
</x-app-layout>
@push('scripts')
<script>
const productId = @json($product->product_id);
const autoSaveUrl = @json(route('products.autosave', $product->product_id));
let autoSaveTimeout;

function showAutoSaveStatus(msg, success = true) {
    let status = document.getElementById('autosave-status');
    if (!status) {
        status = document.createElement('div');
        status.id = 'autosave-status';
        status.style.position = 'fixed';
        status.style.top = '1.5rem';
        status.style.right = '2rem';
        status.style.zIndex = 9999;
        status.style.padding = '0.7rem 1.5rem';
        status.style.borderRadius = '0.5rem';
        status.style.background = success ? '#22c55e' : '#ef4444';
        status.style.color = '#fff';
        status.style.fontWeight = 'bold';
        document.body.appendChild(status);
    }
    status.textContent = msg;
    status.style.display = 'block';
    setTimeout(() => { status.style.display = 'none'; }, 1800);
}

function autoSaveProduct(field, value) {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        const formData = new FormData();
        formData.append(field, value);
        fetch(autoSaveUrl, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAutoSaveStatus('Auto-saved');
            } else {
                showAutoSaveStatus('Auto-save failed', false);
            }
        })
        .catch(() => showAutoSaveStatus('Auto-save failed', false));
    }, 400);
}

document.addEventListener('DOMContentLoaded', function() {
    // Disable submit button
    const submitBtn = document.querySelector('button[type=submit]');
    if (submitBtn) submitBtn.disabled = true;

    // Text/number/textarea fields
    ['name','quantity','price','description'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            if (id === 'description') {
                el.addEventListener('change', e => autoSaveProduct(id, el.value.trim()));
                el.addEventListener('blur', e => autoSaveProduct(id, el.value.trim()));
            } else {
                el.addEventListener('change', e => autoSaveProduct(id, el.value));
                el.addEventListener('blur', e => autoSaveProduct(id, el.value));
            }
        }
    });
    // Category/status (selects)
    ['category','status'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', e => autoSaveProduct(id, el.value));
        }
    });
    // Multi-selects (colors, sizes)
    ['colors','sizes'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', e => {
                const selected = Array.from(el.selectedOptions).map(opt => opt.value);
                autoSaveProduct(id, selected);
            });
        }
    });
});
</script>
@endpush 