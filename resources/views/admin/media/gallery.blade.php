@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">COLLEGE IMAGE GALLERY</h4>
            <a href="{{ route('admin.media.gallery.create') }}" class="btn btn-primary">Add New Images</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.media.gallery') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <select name="college_id" class="form-select select2">
                            <option value="">Filter by College</option>
                            @foreach($colleges as $col)
                                <option value="{{ $col->college_id }}" {{ request('college_id') == $col->college_id ? 'selected' : '' }}>{{ $col->college_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="row">
                @forelse ($galleries as $item)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card shadow-sm border h-100">
                            <img src="{{ asset('storage/'.$item->image_path) }}" class="card-img-top" alt="Gallery Image" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <small class="d-block text-muted text-truncate mb-2" title="{{ $item->college->college_name ?? 'Unknown College' }}">
                                    {{ $item->college->college_name ?? 'Unknown College' }}
                                </small>
                                <form action="{{ route('admin.media.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center">No images found in gallery.</div>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $galleries->links() }}
            </div>
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
            placeholder: "Filter by College",
            allowClear: true
        });
    });
</script>
@endsection
