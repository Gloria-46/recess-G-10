<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
        <h2 class="mb-4">Staff Members</h2>

        {{-- Flash success message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Action Buttons --}}
        <div class="mb-3">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">+ Add Staff Member</a>
            <a href="{{ route('staff.auto.assign') }}" class="btn btn-success">Auto Assign Stages</a>
        </div>

        {{-- Staff Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Hire Date</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Production Stage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staffMembers as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->age }}</td>
                            <td>{{ \Carbon\Carbon::parse($staff->hire_date)->format('d M, Y') }}</td>
                            <td>{{ $staff->phone }}</td>
                            <td>{{ ucfirst($staff->gender) }}</td>
                            <td>{{ $staff->address }}</td>
                            <td>{{ $staff->stage?->name ?? 'Unassigned' }}</td>
                            <td>
                                <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No staff members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
