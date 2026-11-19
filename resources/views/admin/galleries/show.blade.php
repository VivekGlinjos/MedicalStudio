@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Manage Gallery: {{ $college->college_name }}</h4>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm">Back to Galleries</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <form action="{{ route('admin.galleries.store', $college->college_id) }}" method="POST" enctype="multipart/form-data" class="mb-5">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="gallery_images" class="form-label">Add New Images (Multiple allowed, Max 3MB each)</label>
                                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" accept="image/jpeg,image/png,image/webp" multiple required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-upload"></i> Upload Images
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Gallery Grid -->
                    <h5 class="mb-3">Current Gallery Images ({{ $college->galleries->count() }})</h5>
                    
                    @if($college->galleries->count() > 0)
                        <div class="row g-4">
                            @foreach($college->galleries as $gallery)
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm border">
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <img src="{{ Storage::url($gallery->image_path) }}" class="card-img-top" alt="Gallery Image" style="height: 200px; object-fit: cover;">
                                            <div class="card-body text-center mt-auto p-2 border-top">
                                                <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                        <i class="bi bi-trash"></i> Delete Image
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            No images found in the gallery for this college.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
