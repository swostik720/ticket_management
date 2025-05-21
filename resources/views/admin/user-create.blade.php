@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Create New User</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            <div class="form-text">Username will be automatically generated from email.</div>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="head_of_department" {{ old('role') == 'head_of_department' ? 'selected' : '' }}>Head of Department</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="head_office_staff" {{ old('role') == 'head_office_staff' ? 'selected' : '' }}>Head Office Staff</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select id="department_id" class="form-select @error('department_id') is-invalid @enderror" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Required for all roles except Admin.</div>
                            @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select id="branch_id" class="form-select @error('branch_id') is-invalid @enderror" name="branch_id">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Required for all roles except Admin.</div>
                            @error('branch_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Username and password will be automatically generated and sent to respective mail.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const departmentSelect = document.getElementById('department_id');
        const branchSelect = document.getElementById('branch_id');

        function toggleRequiredFields() {
            const isAdmin = roleSelect.value === 'admin';

            if (isAdmin) {
                departmentSelect.removeAttribute('required');
                branchSelect.removeAttribute('required');
            } else {
                departmentSelect.setAttribute('required', 'required');
                branchSelect.setAttribute('required', 'required');
            }
        }

        roleSelect.addEventListener('change', toggleRequiredFields);
        toggleRequiredFields();
    });
</script>
@endsection
