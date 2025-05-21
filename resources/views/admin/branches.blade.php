@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Branches</h1>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i> Add Branch
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">All Branches</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Tickets</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                            <tr>
                                <td>{{ $branch->id }}</td>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ $branch->tickets_count }}</td>
                                <td>{{ $branch->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No branches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
