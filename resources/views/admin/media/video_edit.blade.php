@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Video: {{ $video->video_name }}</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.media.video.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="video_name" class="form-label">Video Title <span class="text-danger">*</span></label>
                        <input type="text" name="video_name" id="video_name" class="form-control" value="{{ old('video_name', $video->video_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="video_link" class="form-label">Video YouTube Link <span class="text-danger">*</span></label>
                        <input type="url" name="video_link" id="video_link" class="form-control" value="{{ old('video_link', $video->video_link) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="thumbnail" class="form-label">Custom Thumbnail Image (Max 2MB)</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($video->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$video->thumbnail) }}" alt="Current Thumbnail" height="60" class="rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.media.videos') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Video</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
