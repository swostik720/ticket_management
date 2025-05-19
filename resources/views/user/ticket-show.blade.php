@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Ticket #{{ $ticket->id }}: {{ $ticket->title }}</h4>
                    <span class="badge bg-{{ $ticket->status === 'open' ? 'danger' : ($ticket->status === 'in_progress' ? 'warning' : ($ticket->status === 'closed' ? 'success' : ($ticket->status === 'escalated' ? 'info' : 'secondary'))) }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Department:</strong> {{ $ticket->department->name }}</p>
                            <p><strong>Created at:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Urgency:</strong>
                                <span class="badge bg-{{ $ticket->urgency === 'low' ? 'success' : ($ticket->urgency === 'medium' ? 'warning' : ($ticket->urgency === 'high' ? 'danger' : 'dark')) }}">
                                    {{ ucfirst($ticket->urgency) }}
                                </span>
                            </p>
                            <p><strong>Assigned to:</strong> {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Not assigned yet' }}</p>
                            <p><strong>Last updated:</strong> {{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $ticket->description }}
                        </div>
                    </div>

                    @if($ticket->attachment)
                    <div class="mb-4">
                        <h5>Attachment</h5>
                        <div class="p-3 bg-light rounded">
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download me-2"></i> Download Attachment
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
