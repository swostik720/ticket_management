@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Staff Dashboard</h1>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> You are a staff member in the <strong>{{ $user->department->name ?? 'No Department' }}</strong> department at <strong>{{ $user->branch->name ?? 'No Branch' }}</strong> branch.
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">My Tickets</h5>
                    <p class="card-text display-6">{{ $ticketCounts['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Open</h5>
                    <p class="card-text display-6">{{ $ticketCounts['open'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <p class="card-text display-6">{{ $ticketCounts['in_progress'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Closed</h5>
                    <p class="card-text display-6">{{ $ticketCounts['closed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Tickets</h4>
        <a href="{{ route('staff.tickets.create') }}" class="btn btn-danger">
            <i class="fas fa-plus-circle me-2"></i> Create New Ticket
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">My Submitted Tickets</h5>
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
                                    <a href="{{ route('staff.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No tickets found. Create your first ticket!</td>
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
