@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Blog Post</h4>
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

            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label">Post Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $blog->category) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="author" class="form-label">Author Name</label>
                        <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $blog->author) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', $blog->tags) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="image" class="form-label">Featured Image (Max 3MB)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($blog->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$blog->image) }}" alt="Current Image" height="80" class="rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <label for="excerpt" class="form-label">Short Excerpt (Summary) <span class="text-danger">*</span></label>
                        <textarea name="excerpt" id="excerpt" class="form-control" rows="3" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="content" class="form-label">Full Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $blog->content) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="seo_text" class="form-label">SEO Meta Description</label>
                        <textarea name="seo_text" id="seo_text" class="form-control" rows="2">{{ old('seo_text', $blog->seo_text) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="published" id="published" value="1" {{ old('published', $blog->published) ? 'checked' : '' }}>
                            <label class="form-check-label" for="published">Published</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Blog Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#content')).catch(error => console.error(error));
</script>
@endsection
