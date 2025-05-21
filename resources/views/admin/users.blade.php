@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">User Management</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-danger">
            <i class="fas fa-user-plus me-2"></i> Create New User
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">All Users</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select form-select-sm me-2" onchange="this.form.submit()" style="width: auto;">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="head_of_department" {{ $user->role === 'head_of_department' ? 'selected' : '' }}>Head of Department</option>
                                            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="head_office_staff" {{ $user->role === 'head_office_staff' ? 'selected' : '' }}>Head Office Staff</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $user->department->name ?? 'N/A' }}</td>
                                <td>{{ $user->branch->name ?? 'N/A' }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
