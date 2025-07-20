<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
            <x-app.navbar />
            <h2 class="mb-3">Add New Staff Member</h2>

            <form action="{{ route('staff.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Date of Birth:</label>
                    <input type="date" name="birth_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Date of Hire:</label>
                    <input type="date" name="hire_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Telephone Contact:</label>
                    <input type="tel" name="phone" class="form-control" required placeholder="e.g. +2567XXXXXXXX">
                </div>

                <div class="mb-3">
                    <label>Gender:</label>
                    <select name="gender" class="form-select" required>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Address:</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Staff Member</button>
            </form>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>
