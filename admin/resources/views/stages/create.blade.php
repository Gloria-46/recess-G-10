<x-app-layout>
<div class="container py-4" style="width: 80vh">
    <h2 class="mb-3">Add Production Stage (Allocation Place)</h2>

    <form action="{{ route('stages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Cutting" required>
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" placeholder="e.g. Cutting raw cloth into patterns..."></textarea>
        </div>

        <div class="mb-3">
            <label>Order in Process:</label>
            <input type="number" name="order" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Max Staff (optional):</label>
            <input type="number" name="max_staff" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Stage</button>
    </form>
</div>
</x-app-layout>