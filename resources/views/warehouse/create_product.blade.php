<x-app-layout>
    <div class="card" style="max-width: 600px; margin: 2rem auto;">
        <h2 class="card-title">Add New Product</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:1rem;">
                <label for="name" style="font-weight:600; color:#1e3a8a;">Name</label>
                <input type="text" name="name" id="name" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="category" style="font-weight:600; color:#1e3a8a;">Category</label>
                <select name="category" id="category" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    <option value="">Select Category</option>
                    <option value="Ladies">Ladies</option>
                    <option value="Gentlemen">Gentlemen</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="quantity" style="font-weight:600; color:#1e3a8a;">Quantity</label>
                <input type="number" name="quantity" id="quantity" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;" required>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="reorder_level" style="font-weight:600; color:#1e3a8a;">Reorder Level</label>
                <input type="number" name="reorder_level" id="reorder_level" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;" value="10" min="0">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="price" style="font-weight:600; color:#1e3a8a;">Price</label>
                <input type="number" step="0.01" name="price" id="price" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="colors" style="font-weight:600; color:#1e3a8a;">Colors</label>
                <input type="text" name="colors" id="colors" placeholder="e.g. Red, Blue, Green" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="sizes" style="font-weight:600; color:#1e3a8a;">Sizes</label>
                <input type="text" name="sizes" id="sizes" placeholder="e.g. S, M, L, XL" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="status" style="font-weight:600; color:#1e3a8a;">Status</label>
                <select name="status" id="status" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
                    <option value="Active" selected>Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="description" style="font-weight:600; color:#1e3a8a;">Description</label>
                <textarea name="description" id="description" rows="3" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;"></textarea>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="batch" style="font-weight:600; color:#1e3a8a;">Batch</label>
                <input type="text" name="batch" id="batch" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="image" style="font-weight:600; color:#1e3a8a;">Image</label>
                <input type="file" name="image" id="image" style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="date" style="font-weight:600; color:#1e3a8a;">Date</label>
                <input type="datetime-local" name="date" id="date" style="width:100%; border-radius:0.25rem; border:1px solid #e0e7ef; padding:0.5rem;">
            </div>
            <button type="submit" class="btn-blue">Add Product</button>
        </form>
    </div>
</x-app-layout> 