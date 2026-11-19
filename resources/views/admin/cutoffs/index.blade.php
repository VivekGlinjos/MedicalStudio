@extends('admin.backend_master')

@section('contentpanel')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Past Allotments (Cutoffs)</h4>
            <div>
                <a href="{{ route('admin.cutoffs.manage') }}" class="btn btn-dark me-2">
                    <i class="fa-solid fa-list-check me-1"></i> Manage Cutoffs
                </a>
                <a href="{{ route('admin.cutoffs.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i> Add Cutoff
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light rounded-top border-bottom">
            <form method="GET" action="{{ route('admin.cutoffs.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted small text-uppercase">College</label>
                    <select name="college_id" class="form-select">
                        <option value="">All Colleges</option>
                        @foreach($colleges as $c)
                            <option value="{{ $c->college_id }}" {{ request('college_id') == $c->college_id ? 'selected' : '' }}>
                                {{ $c->college_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold text-muted small text-uppercase">Year</label>
                    <select name="year" class="form-select">
                        <option value="">All Years</option>
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold text-muted small text-uppercase">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark text-white flex-grow-1"><i class="fa-solid fa-search me-1 text-white"></i> Search</button>
                    <a href="{{ route('admin.cutoffs.index') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="fa-solid fa-rotate-right"></i> Reset</a>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">College</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Round</th>
                            <th>Quota</th>
                            <th>Category</th>
                            <th>Closing Rank</th>
                            <th>Closing Score</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cutoffs as $c)
                        <tr>
                            <td class="ps-4 fw-bold" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $c->college->college_name ?? 'N/A' }}">
                                {{ $c->college->college_name ?? 'N/A' }}
                            </td>
                            <td>{{ $c->course->name ?? 'N/A' }}</td>
                            <td>{{ $c->year }}</td>
                            <td>Round {{ $c->round }}</td>
                            <td><span class="badge bg-secondary">{{ $c->quota }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $c->category }}</span></td>
                            <td class="fw-bold">{{ $c->closing_rank }}</td>
                            <td>{{ $c->closing_score ?? '-' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.cutoffs.edit', $c->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.cutoffs.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No cutoffs found matching criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top">
            {{ $cutoffs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
