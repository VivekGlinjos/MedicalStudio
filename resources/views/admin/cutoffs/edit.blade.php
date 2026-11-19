@extends('admin.backend_master')

@section('contentpanel')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Past Allotment (Cutoff)</h5>
                    <a href="{{ route('admin.cutoffs.index') }}" class="btn btn-sm btn-outline-secondary">Back to List</a>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.cutoffs.update', $cutoff->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">College <span class="text-danger">*</span></label>
                                <select name="college_id" class="form-select" required>
                                    <option value="">Select College</option>
                                    @foreach($colleges as $c)
                                        <option value="{{ $c->college_id }}" {{ old('college_id', $cutoff->college_id) == $c->college_id ? 'selected' : '' }}>{{ $c->college_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" class="form-select" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('course_id', $cutoff->course_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control" value="{{ old('year', $cutoff->year) }}" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Round <span class="text-danger">*</span></label>
                                <input type="number" name="round" class="form-control" value="{{ old('round', $cutoff->round) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quota <span class="text-danger">*</span></label>
                                <input type="text" name="quota" class="form-control" value="{{ old('quota', $cutoff->quota) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" class="form-control" value="{{ old('category', $cutoff->category) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Closing Rank <span class="text-danger">*</span></label>
                                <input type="number" name="closing_rank" class="form-control" value="{{ old('closing_rank', $cutoff->closing_rank) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Closing Score</label>
                                <input type="number" name="closing_score" class="form-control" value="{{ old('closing_score', $cutoff->closing_score) }}">
                                <small class="text-muted">Optional</small>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-4">Update Record</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
