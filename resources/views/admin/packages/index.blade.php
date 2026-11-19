@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">SERVICE PACKAGES</h4>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Add New Package</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Tier</th>
                            <th>Amount (₹)</th>
                            <th>Payment Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $item)
                        <tr>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>
                                @if($item->tier == 'Basic')
                                    <span class="badge bg-secondary">Basic</span>
                                @elseif($item->tier == 'Premium')
                                    <span class="badge bg-primary">Premium</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pro</span>
                                @endif
                            </td>
                            <td>₹{{ number_format($item->amount, 2) }}</td>
                            <td>
                                @if($item->payment_button_link && $item->payment_button_link !== '#')
                                    <a href="{{ $item->payment_button_link }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-link-45deg"></i> Link</a>
                                @else
                                    <span class="text-muted">Not Set</span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.packages.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('admin.packages.toggle', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi {{ $item->is_active ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.packages.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No packages found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
