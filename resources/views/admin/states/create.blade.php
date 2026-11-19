@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add New State</h4>
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

            <form action="{{ route('admin.states.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">State Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="code" class="form-label">State Code (e.g. KL, MH)</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="region" class="form-label">Region (e.g. South, North)</label>
                        <input type="text" name="region" id="region" class="form-control" value="{{ old('region') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cover_image" class="form-label">Cover Image (Max 3MB)</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.states.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save State</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
