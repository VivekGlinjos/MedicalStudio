@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">ENQUIRIES</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.enquiries.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search name, email, phone, location..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" title="Date From">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" title="Date To">
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="NEET PG Predictor Alert" {{ request('type') == 'NEET PG Predictor Alert' ? 'selected' : '' }}>PG Predictor Alerts</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Enquiry For</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                            <td><a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></td>
                            <td>
                                @if($item->enquiry_for === 'NEET PG Predictor Alert')
                                    <span class="badge bg-danger">NEET PG Predictor Alert</span>
                                @else
                                    {{ $item->enquiry_for ?? 'General' }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.enquiries.show', $item->id) }}" class="btn btn-sm btn-info text-white" title="View Details"><i class="bi bi-eye"></i></a>
                                    
                                    <form action="{{ route('admin.enquiries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No enquiries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $enquiries->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
