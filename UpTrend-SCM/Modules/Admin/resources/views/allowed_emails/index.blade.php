<x-app-layout>
    <div class="container py-4" style="margin-left: 20%; width: 80vw;">
        <x-app.navbar/>
        <h2 class="mb-4">Allowed Emails</h2>
        <a href="{{ route('admin.allowed_emails.create') }}" 
        class="btn btn-primary">
        Add Allowed Email</a>

        {{-- Flash success message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allowedEmails as $allowedEmail)
                        <tr>
                            <td>{{ $allowedEmail->email }}</td>
                            <td>{{ $allowedEmail->role }}</td>
                            <td>
                                <!-- Edit Icon -->
                                <a href="{{ route('admin.allowed_emails.edit', $allowedEmail) }}" 
                                    class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; border-radius: 10%; margin-right: 6px; background-color: transparent; border: solid 1px grey"
                                    title="Edit">
                                    <i class="ni ni-single-copy-04" style="font-size: 1.2rem; color: grey"></i>
                                
                                </a>

                                <!-- Delete Icon -->
                                <form action="{{ route('admin.allowed_emails.destroy', $allowedEmail) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                    class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; border-radius: 10%; margin-right: 6px; background-color: transparent; border: solid 1px grey"
                                    title="Delete" 
                                    onclick="return confirm('Are you sure?')">
                                        <i class="ni ni-fat-remove" style="font-size: 2rem; color: grey"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
