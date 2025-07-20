{{-- <x-app-layout>
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Add Allowed Email</h2>
    <form method="POST" action="{{ route('admin.allowed_emails.store') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" class="border px-2 py-1 w-full" required>
            @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="role" class="block">Role</label>
            <select name="role" id="role" class="border px-2 py-1 w-full" required>
                <option value="admin">Admin</option>
                <option value="vendor">Vendor</option>
                <option value="warehouse">Warehouse</option>
                <option value="retailer">Retailer</option>
            </select>
            @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
        <a href="{{ route('admin.allowed_emails.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection  --}}
<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
            <x-app.navbar />
            <h2 class="mb-3">Add Allowed Email</h2>

            <form method="POST" action="{{ route('admin.allowed_emails.store') }}">
                @csrf

                <div class="mb-3" style="width: 40vw">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3" style="width: 40vw">
                    <label style="width: 40vw">Role:</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="vendor">Vendor</option>
                        <option value="warehouse">Warehouse</option>
                        <option value="retailer">Retailer</option>
                    </select>
                    @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
                <a href="{{ route('admin.allowed_emails.index') }}" class="ml-4 text-gray-600">Cancel</a>
            </form>
    </div>
</x-app-layout>
