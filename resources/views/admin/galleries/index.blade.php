@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">College Galleries</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.galleries.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search colleges..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>College Name</th>
                            <th>Place</th>
                            <th>Images in Gallery</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colleges as $college)
                        <tr>
                            <td>{{ $college->college_name }}</td>
                            <td>{{ $college->place }}</td>
                            <td>
                                <span class="badge bg-info">{{ $college->galleries->count() }} Images</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.galleries.show', $college->college_id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-images"></i> Manage Gallery
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No colleges found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $colleges->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
