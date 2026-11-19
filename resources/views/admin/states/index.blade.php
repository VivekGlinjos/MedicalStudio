@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">STATES</h4>
            <a href="{{ route('admin.states.create') }}" class="btn btn-primary">Add New State</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.states.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search state name" value="{{ request('search') }}">
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
                            <th>Cover Image</th>
                            <th>State Name</th>
                            <th>Code</th>
                            <th>Region</th>
                            <th>Colleges Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($states as $item)
                        <tr>
                            <td>
                                @if($item->cover_image)
                                    <img class="rounded" height="40" width="60" src="{{ asset('storage/'.$item->cover_image) }}" alt="">
                                @else
                                    <div class="rounded bg-secondary d-flex justify-content-center align-items-center text-white" style="width:60px; height:40px;"><i class="bi bi-map"></i></div>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code ?? '-' }}</td>
                            <td>{{ $item->region ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $item->colleges_count }} Colleges</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.states.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('admin.states.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure? This state might be linked to multiple colleges.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No states found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $states->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
