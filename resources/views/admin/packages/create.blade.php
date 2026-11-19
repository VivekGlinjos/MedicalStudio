@extends('admin.backend_master')

@section('contentpanel')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add New Service Package</h4>
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

            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Package Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tier" class="form-label">Tier <span class="text-danger">*</span></label>
                        <select name="tier" id="tier" class="form-select" required>
                            <option value="Basic" {{ old('tier') == 'Basic' ? 'selected' : '' }}>Basic</option>
                            <option value="Premium" {{ old('tier') == 'Premium' ? 'selected' : '' }}>Premium</option>
                            <option value="Pro" {{ old('tier') == 'Pro' ? 'selected' : '' }}>Pro</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="payment_button_link" class="form-label">External Payment Link (Razorpay/Stripe)</label>
                        <input type="text" name="payment_button_link" id="payment_button_link" class="form-control" value="{{ old('payment_button_link') }}" placeholder="https://... or <form>...">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Select Package Image</label>
                        <div class="d-flex gap-4 mt-2">
                            <label class="form-check" style="cursor: pointer;">
                                <input type="radio" class="form-check-input" name="image" value="pkg_1.png" checked>
                                <span class="ms-1">Image 1</span>
                                <img src="{{ asset('images/pkg_1.png') }}" class="d-block mt-2 rounded border" style="width:120px;height:70px;object-fit:cover;">
                            </label>
                            <label class="form-check" style="cursor: pointer;">
                                <input type="radio" class="form-check-input" name="image" value="pkg_2.png">
                                <span class="ms-1">Image 2</span>
                                <img src="{{ asset('images/pkg_2.png') }}" class="d-block mt-2 rounded border" style="width:120px;height:70px;object-fit:cover;">
                            </label>
                            <label class="form-check" style="cursor: pointer;">
                                <input type="radio" class="form-check-input" name="image" value="pkg_3.png">
                                <span class="ms-1">Image 3</span>
                                <img src="{{ asset('images/pkg_3.png') }}" class="d-block mt-2 rounded border" style="width:120px;height:70px;object-fit:cover;">
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Description (Features included) <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Publish immediately (Active)</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Package</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
</script>
@endsection
