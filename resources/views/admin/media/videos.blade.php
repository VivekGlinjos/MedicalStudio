@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">VIDEO GALLERY</h4>
            <a href="{{ route('admin.media.video.create') }}" class="btn btn-primary">Add New Video</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.media.videos') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search video title..." value="{{ request('search') }}">
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
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Video Link</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videos as $item)
                        <tr>
                            <td>
                                @if($item->thumbnail)
                                    <img class="rounded" height="50" width="80" src="{{ asset('storage/'.$item->thumbnail) }}" alt="" style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-secondary d-flex justify-content-center align-items-center text-white" style="width:80px; height:50px;"><i class="bi bi-play-circle-fill fs-4"></i></div>
                                @endif
                            </td>
                            <td><strong>{{ $item->video_name }}</strong></td>
                            <td><a href="{{ $item->video_link }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-youtube"></i> Watch</a></td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.media.video.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('admin.media.video.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No videos found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
