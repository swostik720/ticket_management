@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4">Head Office Staff Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Tickets</h5>
                        <p class="card-text display-6">{{ $ticketCounts['total'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">In Progress</h5>
                        <p class="card-text display-6">{{ $ticketCounts['in_progress'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Closed</h5>
                        <p class="card-text display-6">{{ $ticketCounts['closed'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Escalated</h5>
                        <p class="card-text display-6">{{ $ticketCounts['escalated'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Not Resolved</h5>
                        <p class="card-text display-6">{{ $ticketCounts['not_resolved'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Created by Me</h5>
                        <p class="card-text display-6">{{ $ticketCounts['created'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{ route('head_office.tickets.create') }}" class="btn btn-danger">
                <i class="fas fa-plus-circle me-2"></i> Create New Ticket
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">My Tickets</h5>
            </div>
            <div class="card-body">
                @if ($tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th>Urgency</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->department->name }}</td>
                                        <td>{{ $ticket->branch->name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $ticket->status === 'open' ? 'danger' : ($ticket->status === 'in_progress' ? 'warning' : ($ticket->status === 'closed' ? 'success' : ($ticket->status === 'escalated' ? 'info' : 'secondary'))) }}">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $ticket->urgency === 'low' ? 'success' : ($ticket->urgency === 'medium' ? 'warning' : ($ticket->urgency === 'high' ? 'danger' : 'dark')) }}">
                                                {{ ucfirst($ticket->urgency) }}
                                            </span>
                                        </td>
                                        <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('head_office.tickets.show', $ticket->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $tickets->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        No tickets found. <a href="{{ route('head_office.tickets.create') }}" class="alert-link">Create a
                            new ticket</a>.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
