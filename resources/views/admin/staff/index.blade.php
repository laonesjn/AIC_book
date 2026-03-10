@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi bi-people-fill me-2" style="color:var(--primary)"></i>Staff Management</h1>
        <p><i class="bi bi-house"></i> Dashboard / Staff</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.staff.create') }}" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Add Staff</a>
    </div>
</div>

<div class="card animate-in delay-1">
    <div class="card-body">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $s)
                    <tr>
                        <td><strong>{{ $s->name }}</strong></td>
                        <td>{{ $s->email }}</td>
                        <td>
                            @if($s->permissions)
                                @foreach($s->permissions as $p)
                                    <span class="badge bg-info text-dark">{{ $p }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No permissions</span>
                            @endif
                        </td>
                        <td>{{ $s->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.staff.edit', $s->id) }}" class="action-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.staff.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn reject-btn" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No staff users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
