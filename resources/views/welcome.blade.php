@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- <div class="row mb-4">
        <div class="col-md-12">
            <div class="jumbotron bg-light p-5 rounded">
                <h1 class="display-4">Welcome to Ticket Management System</h1>
                <p class="lead">View all tickets and their status below. Login to create or manage tickets.</p>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @else
                    @staff
                        <a href="{{ route('staff.tickets.create') }}" class="btn btn-success">Create New Ticket</a>
                    @endstaff
                @endguest
            </div>
        </div>
    </div> --}}

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">All Tickets</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Submitted By</th>
                            <th>Assigned To</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>{{ $ticket->branch->name }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Not assigned' }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->urgency === 'low' ? 'success' : ($ticket->urgency === 'medium' ? 'warning' : ($ticket->urgency === 'high' ? 'danger' : 'dark')) }}">
                                        {{ ucfirst($ticket->urgency) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status === 'open' ? 'danger' : ($ticket->status === 'in_progress' ? 'warning' : ($ticket->status === 'closed' ? 'success' : ($ticket->status === 'escalated' ? 'info' : 'secondary'))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                <td>
                                    @auth
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-sign-in-alt"></i> Login to View
                                        </a>
                                    @endauth
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
