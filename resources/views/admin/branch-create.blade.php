@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Create New Branch</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.branches.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Branch Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.branches') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Create Branch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
