@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">BLOGS</h4>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Create New Blog Post</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.blogs.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search title or author" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="published" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('published') == '1' ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ request('published') == '0' ? 'selected' : '' }}>Draft</option>
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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img class="rounded" height="40" width="60" src="{{ asset('storage/'.$item->image) }}" alt="" style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-secondary d-flex justify-content-center align-items-center text-white" style="width:60px; height:40px;"><i class="bi bi-image"></i></div>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->title, 40) }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->author }}</td>
                            <td>
                                @if($item->published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.blogs.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('admin.blogs.toggle', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->published ? 'btn-warning' : 'btn-success' }}" title="{{ $item->published ? 'Unpublish' : 'Publish' }}">
                                            <i class="bi {{ $item->published ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.blogs.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No blog posts found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
