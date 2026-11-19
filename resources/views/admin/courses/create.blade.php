@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add New Course</h4>
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

            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="level" class="form-label">Level <span class="text-danger">*</span></label>
                        <select name="level" id="level" class="form-select" required>
                            <option value="UG" {{ old('level') == 'UG' ? 'selected' : '' }}>Undergraduate (UG)</option>
                            <option value="PG" {{ old('level') == 'PG' ? 'selected' : '' }}>Postgraduate (PG)</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration') }}" placeholder="e.g. 5.5 Years">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Course Icon/Image (Max 3MB)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="banner" class="form-label">Banner Image (Max 5MB)</label>
                        <input type="file" name="banner" id="banner" class="form-control" accept="image/jpeg,image/png,image/webp">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="short_note" class="form-label">Short Note</label>
                        <textarea name="short_note" id="short_note" class="form-control" rows="2">{{ old('short_note') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Detailed Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="admission_requirements" class="form-label">Admission Requirements</label>
                        <textarea name="admission_requirements" id="admission_requirements" class="form-control" rows="5">{{ old('admission_requirements') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="seo_text" class="form-label">SEO Text</label>
                        <textarea name="seo_text" id="seo_text" class="form-control" rows="2">{{ old('seo_text') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Publish immediately (Active)</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Course</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#admission_requirements')).catch(error => console.error(error));
</script>
@endsection
