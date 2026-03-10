@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi bi-person-gear me-2" style="color:var(--primary)"></i>Edit Staff: {{ $staff->name }}</h1>
        <p><i class="bi bi-house"></i> Dashboard / Staff / Edit</p>
    </div>
</div>

<div class="card animate-in delay-1" style="max-width: 800px;">
    <div class="card-body">
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $staff->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $staff->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label d-block">Permissions</label>
                @php
                    $perms = ['Collection', 'Heritage', 'Publications', 'Virtual Exhibition', 'Members'];
                    $currentPerms = $staff->permissions ?? [];
                @endphp
                <div class="row">
                    @foreach($perms as $p)
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $p }}" id="perm_{{ $loop->index }}"
                                {{ in_array($p, $currentPerms) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $loop->index }}">
                                {{ $p }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom">Update Staff</button>
                <a href="{{ route('admin.staff.index') }}" class="btn-secondary-custom">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
