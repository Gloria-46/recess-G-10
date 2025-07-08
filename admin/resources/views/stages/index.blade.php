<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
        <h2 class="mb-4">Production Stages</h2>

        {{-- Flash success message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Action Buttons --}}
        <div class="mb-3">
            <a href="{{ route('stages.create') }}" class="btn btn-primary">+ Add Production Stage</a>
        </div>

        {{-- Stages Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Max Staff</th>
                        <th>Current Staff</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stages as $index => $stage)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $stage->name }}</td>
                            <td>{{ $stage->description }}</td>
                            <td>{{ $stage->order }}</td>
                            <td>{{ $stage->max_staff ?? 'Unlimited' }}</td>
                            <td>{{ $stage->staff_count ?? ($stage->staff ? $stage->staff->count() : 0) }}</td>
                            <td>
                                <a href="{{ route('stages.edit', $stage->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('stages.destroy', $stage->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stage?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No production stages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
