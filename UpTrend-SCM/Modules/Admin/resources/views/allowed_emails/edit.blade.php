<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
        <x-app.navbar/>
        <h2 class="mb-3">Edit Allowed Email</h2>

        <form method="POST" action="{{ route('admin.allowed_emails.update', $allowedEmail) }}">
            @csrf
            @method('PUT')

            <div class="mb-3" style="width: 40vw">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $allowedEmail->email) }}" required>
                @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3" style="width: 40vw">
                <label style="width: 40vw">Role:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin" @if($allowedEmail->role=='admin') selected @endif>Admin</option>
                    <option value="vendor" @if($allowedEmail->role=='vendor') selected @endif>Vendor</option>
                    <option value="warehouse" @if($allowedEmail->role=='warehouse') selected @endif>Warehouse</option>
                    <option value="retailer" @if($allowedEmail->role=='retailer') selected @endif>Retailer</option>
                </select>
                @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.allowed_emails.index') }}" class="ml-4 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>