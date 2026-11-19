@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">COURSES</h4>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Add New Course</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Course Name</th>
                            <th>Level</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $item)
                        <tr>
                            <td>
                                @if($item->image && file_exists(public_path('storage/'.$item->image)))
                                    <img class="rounded-circle" height="40" width="40" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex justify-content-center align-items-center" style="width:40px; height:40px; background: rgba(29, 78, 216, 0.1); color: #1d4ed8;">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ $item->duration }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.courses.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('admin.courses.toggle', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fa-solid {{ $item->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.courses.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No courses found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
