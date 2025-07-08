<x-app-layout>
<div class="container py-4" style="width: 80vh">
    <h2 class="mb-3">Edit Production Stage</h2>
    <form action="{{ route('stages.update', $stage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $stage->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control">{{ old('description', $stage->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Order in Process:</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $stage->order) }}" required>
        </div>
        <div class="mb-3">
            <label>Max Staff (optional):</label>
            <input type="number" name="max_staff" class="form-control" value="{{ old('max_staff', $stage->max_staff) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Stage</button>
    </form>
</div>
</x-app-layout> 