@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit College: {{ $college->college_name }}</h4>
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

            <form action="{{ route('admin.colleges.update', $college->college_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                        <input type="text" name="college_name" id="college_name" class="form-control" value="{{ old('college_name', $college->college_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="place" class="form-label">Place <span class="text-danger">*</span></label>
                        <input type="text" name="place" id="place" class="form-control" value="{{ old('place', $college->place) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                        <select name="state_id" id="state_id" class="form-select" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id', $college->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="college_type" class="form-label">College Type <span class="text-danger">*</span></label>
                        <select name="college_type" id="college_type" class="form-select" required>
                            <option value="0" {{ old('college_type', $college->college_type) == '0' ? 'selected' : '' }}>Government</option>
                            <option value="1" {{ old('college_type', $college->college_type) == '1' ? 'selected' : '' }}>Private</option>
                            <option value="2" {{ old('college_type', $college->college_type) == '2' ? 'selected' : '' }}>Deemed</option>
                            <option value="3" {{ old('college_type', $college->college_type) == '3' ? 'selected' : '' }}>Central</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="year_of_inspection" class="form-label">Year of Inspection</label>
                        <input type="text" name="year_of_inspection" id="year_of_inspection" class="form-control" value="{{ old('year_of_inspection', $college->year_of_inspection) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="total_seats" class="form-label">Total Seats</label>
                        <input type="number" name="total_seats" id="total_seats" class="form-control" value="{{ old('total_seats', $college->total_seats) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="hospital_beds" class="form-label">Hospital Beds</label>
                        <input type="number" name="hospital_beds" id="hospital_beds" class="form-control" value="{{ old('hospital_beds', $college->hospital_beds) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="college_fees" class="form-label">College Fees</label>
                        <input type="text" name="college_fees" id="college_fees" class="form-control" value="{{ old('college_fees', $college->college_fees) }}">
                    </div>
                    
                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-12 mb-2"><strong class="text-primary">Cutoff Ranks (Expected/Previous)</strong></div>

                    <div class="col-md-3 mb-3">
                        <label for="general_rank" class="form-label">General Rank</label>
                        <input type="number" name="general_rank" id="general_rank" class="form-control" value="{{ old('general_rank', $college->general_rank) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="obc_rank" class="form-label">OBC Rank</label>
                        <input type="number" name="obc_rank" id="obc_rank" class="form-control" value="{{ old('obc_rank', $college->obc_rank) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="sc_rank" class="form-label">SC Rank</label>
                        <input type="number" name="sc_rank" id="sc_rank" class="form-control" value="{{ old('sc_rank', $college->sc_rank) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="st_rank" class="form-label">ST Rank</label>
                        <input type="number" name="st_rank" id="st_rank" class="form-control" value="{{ old('st_rank', $college->st_rank) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="cutoff_year" class="form-label">Rank Year</label>
                        <select name="cutoff_year" id="cutoff_year" class="form-select">
                            <option value="">Select Year</option>
                            @for($y = date('Y') + 1; $y >= 2018; $y--)
                                <option value="{{ $y }}" {{ old('cutoff_year', $college->cutoff_year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-6 mb-3">
                        <label for="college_image" class="form-label">Profile Image (Max 3MB)</label>
                        <input type="file" name="college_image" id="college_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($college->college_image)
                            <div class="mt-2">
                                <img src="{{ $college->getImageUrl() }}" alt="Current Profile" height="60" class="rounded">
                                <small class="text-muted d-block">Current image</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="college_banner" class="form-label">Banner Image (Max 5MB)</label>
                        <input type="file" name="college_banner" id="college_banner" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($college->college_banner)
                            <div class="mt-2">
                                <img src="{{ $college->getBannerUrl() }}" alt="Current Banner" height="60" class="rounded">
                                <small class="text-muted d-block">Current banner</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="extra_image_1" class="form-label">Extra Image 1</label>
                        <input type="file" name="extra_image_1" id="extra_image_1" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($college->extra_image_1)
                            <div class="mt-2">
                                <img src="{{ Storage::url($college->extra_image_1) }}" alt="Extra Image 1" height="60" class="rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="extra_image_2" class="form-label">Extra Image 2</label>
                        <input type="file" name="extra_image_2" id="extra_image_2" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($college->extra_image_2)
                            <div class="mt-2">
                                <img src="{{ Storage::url($college->extra_image_2) }}" alt="Extra Image 2" height="60" class="rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="extra_image_3" class="form-label">Extra Image 3</label>
                        <input type="file" name="extra_image_3" id="extra_image_3" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if($college->extra_image_3)
                            <div class="mt-2">
                                <img src="{{ Storage::url($college->extra_image_3) }}" alt="Extra Image 3" height="60" class="rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <label for="gallery_images" class="form-label">Add Gallery Images (Multiple allowed)</label>
                        <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                        <small class="text-muted">You can select multiple images to add to the gallery.</small>
                        
                        @if($college->galleries->count() > 0)
                            <div class="mt-3">
                                <label class="form-label fw-bold">Current Gallery Images</label>
                                <p class="text-muted small">Select the images you want to <strong>delete</strong>:</p>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($college->galleries as $gallery)
                                        <div class="border rounded p-2 text-center" style="width: 150px;">
                                            <img src="{{ Storage::url($gallery->image_path) }}" class="img-fluid rounded mb-2" style="height: 80px; object-fit: cover; width: 100%;">
                                            <div class="form-check d-flex justify-content-center align-items-center gap-2">
                                                <input class="form-check-input" type="checkbox" name="delete_galleries[]" value="{{ $gallery->id }}" id="del_gallery_{{ $gallery->id }}">
                                                <label class="form-check-label text-danger small mb-0" for="del_gallery_{{ $gallery->id }}">Delete</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="website_link" class="form-label">Website Link</label>
                        <input type="url" name="website_link" id="website_link" class="form-control" value="{{ old('website_link', $college->website_link) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="2">{{ old('remarks', $college->remarks) }}</textarea>
                    </div>

                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-12 mb-2"><strong class="text-primary">Contact Information</strong></div>

                    <div class="col-md-6 mb-3">
                        <label for="dean_email" class="form-label">Dean Email</label>
                        <input type="email" name="dean_email" id="dean_email" class="form-control" value="{{ old('dean_email', $college->dean_email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dean_contact" class="form-label">Dean Contact No.</label>
                        <input type="text" name="dean_contact" id="dean_contact" class="form-control" value="{{ old('dean_contact', $college->dean_contact) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="principal_email" class="form-label">Principal Email</label>
                        <input type="email" name="principal_email" id="principal_email" class="form-control" value="{{ old('principal_email', $college->principal_email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="principal_contact" class="form-label">Principal Contact No.</label>
                        <input type="text" name="principal_contact" id="principal_contact" class="form-control" value="{{ old('principal_contact', $college->principal_contact) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nodal_email" class="form-label">Nodal Officer Email</label>
                        <input type="email" name="nodal_email" id="nodal_email" class="form-control" value="{{ old('nodal_email', $college->nodal_email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nodal_contact" class="form-label">Nodal Officer Contact No.</label>
                        <input type="text" name="nodal_contact" id="nodal_contact" class="form-control" value="{{ old('nodal_contact', $college->nodal_contact) }}">
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-12 mb-3">
                        <label for="about_us" class="form-label">About College</label>
                        <textarea name="about_us" id="about_us" class="form-control" rows="3">{{ old('about_us', $college->about_us) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="college_description" class="form-label">Detailed Description</label>
                        <textarea name="college_description" id="college_description" class="form-control" rows="6">{{ old('college_description', $college->college_description) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Courses Offered</label>
                        <div class="d-flex flex-wrap gap-3">
                            @php
                                $selectedCourses = is_array(old('courses')) ? old('courses') : explode(',', $college->courses ?? '');
                                $selectedCourses = array_map('trim', $selectedCourses);
                            @endphp
                            @foreach($courses as $course)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->name }}" id="course_{{ $course->id }}" {{ in_array($course->name, $selectedCourses) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="course_{{ $course->id }}">
                                        {{ $course->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="seo_text" class="form-label">SEO Text</label>
                        <textarea name="seo_text" id="seo_text" class="form-control" rows="2">{{ old('seo_text', $college->seo_text) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $college->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Publish immediately (Active)</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.colleges.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update College</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#college_description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
