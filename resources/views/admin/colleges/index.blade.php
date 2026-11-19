@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">COLLEGES</h4>
            <a href="{{ route('admin.colleges.create') }}" class="btn btn-primary">Add New College</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.colleges.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or place" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="state_id" class="form-select">
                            <option value="">All States</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="college_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="0" {{ request('college_type') == '0' ? 'selected' : '' }}>Govt</option>
                            <option value="1" {{ request('college_type') == '1' ? 'selected' : '' }}>Private</option>
                            <option value="2" {{ request('college_type') == '2' ? 'selected' : '' }}>Deemed</option>
                            <option value="3" {{ request('college_type') == '3' ? 'selected' : '' }}>Central</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>College Name</th>
                            <th>State</th>
                            <th>Place</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($colleges as $item)
                        <tr>
                            <td>
                                <img class="rounded-circle" height="40" width="40" src="{{ $item->getImageUrl() }}" style="object-fit: cover;" alt="">
                            </td>
                            <td>{{ $item->college_name }}</td>
                            <td>{{ $item->stateRelation->name ?? 'N/A' }}</td>
                            <td>{{ $item->place }}</td>
                            <td>{{ $item->getTypeLabel() }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.colleges.edit', $item->college_id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('admin.colleges.toggle', $item->college_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi {{ $item->is_active ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.colleges.destroy', $item->college_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this college?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No colleges found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $colleges->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</section>
@endsection
