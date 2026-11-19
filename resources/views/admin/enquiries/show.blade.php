@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Enquiry Details</h4>
            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Date Submitted</h6>
                    <p class="fs-5">{{ $enquiry->created_at->format('d M Y, h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</p>
                </div>
                
                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Enquiry For</h6>
                    <p class="fs-5"><span class="badge bg-primary">{{ $enquiry->enquiry_for ?? 'General' }}</span></p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Name</h6>
                    <p class="fs-5"><strong>{{ $enquiry->name }}</strong></p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Email</h6>
                    <p class="fs-5"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Phone Number</h6>
                    <p class="fs-5"><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-1">Location/City</h6>
                    <p class="fs-5">{{ $enquiry->location ?? 'Not provided' }}</p>
                </div>

                <div class="col-12 mt-2">
                    <h6 class="text-muted mb-2">Message Content</h6>
                    <div class="p-4 bg-light rounded" style="min-height: 120px;">
                        {{ $enquiry->message ?? 'No message content provided.' }}
                    </div>
                </div>
            </div>
            
            <div class="mt-5 text-end border-top pt-4">
                <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Enquiry</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
