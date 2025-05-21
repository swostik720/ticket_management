@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Create New Ticket</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('head_office.tickets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ $department->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch</label>
                                <input type="text" class="form-control" value="{{ $branch->name }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="urgency" class="form-label">Urgency</label>
                            <select id="urgency" class="form-select @error('urgency') is-invalid @enderror" name="urgency" required>
                                <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('urgency') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('urgency') == 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('urgency')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment (optional)</label>
                            <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment">
                            <div class="form-text">Max file size: 10MB</div>
                            @error('attachment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('head_office.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Submit Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
