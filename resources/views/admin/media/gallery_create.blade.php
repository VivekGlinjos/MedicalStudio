@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Images to College Gallery</h4>
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

            <form action="{{ route('admin.media.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="college_id" class="form-label">Select College <span class="text-danger">*</span></label>
                        <select name="college_id" id="college_id" class="form-select select2" required>
                            <option value="">Select College...</option>
                            @foreach($colleges as $col)
                                <option value="{{ $col->college_id }}" {{ old('college_id') == $col->college_id ? 'selected' : '' }}>{{ $col->college_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="caption" class="form-label">Caption (Optional)</label>
                        <input type="text" name="caption" id="caption" class="form-control" value="{{ old('caption') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="images" class="form-label">Upload Images (Max 5MB each) <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" id="images" class="form-control" accept="image/jpeg,image/png,image/webp" multiple required>
                        <small class="text-muted">You can select multiple images at once (Ctrl+Click or Shift+Click).</small>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.media.gallery') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Upload Images</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Select2 for searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select College...",
            allowClear: true
        });
    });
</script>
@endsection
