<x-app-layout>
<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
        <h2 class="mb-3">Edit Staff Member</h2>
        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
            </div>
            <div class="mb-3">
                <label>Age:</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $staff->age) }}" required min="18">
            </div>
            <div class="mb-3">
                <label>Date of Hire:</label>
                <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $staff->hire_date) }}" required>
            </div>
            <div class="mb-3">
                <label>Telephone Contact:</label>
                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $staff->phone) }}" required placeholder="e.g. +2567XXXXXXXX">
            </div>
            <div class="mb-3">
                <label>Gender:</label>
                <select name="gender" class="form-select" required>
                    <option value="female" {{ old('gender', $staff->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="male" {{ old('gender', $staff->gender) == 'male' ? 'selected' : '' }}>Male</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Address:</label>
                <textarea name="address" class="form-control" rows="2" required>{{ old('address', $staff->address) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Staff Member</button>
        </form>
    </div>
</x-app-layout> 
</x-app-layout>