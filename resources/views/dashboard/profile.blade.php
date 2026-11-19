@extends('layouts.dashboard')

@section('title', 'My Profile - Medical Studio')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--blue); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        <h1 class="section-title" style="margin: 0;">My Profile</h1>
        <p style="color: var(--muted); margin-top: 0.5rem;">Manage your personal information and address.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 2rem; padding: 1rem; border-radius: 8px; background: rgba(22, 163, 74, 0.1); color: var(--green); border: 1px solid rgba(22, 163, 74, 0.2);">
            <i class="fa-solid fa-circle-check" style="margin-right: 0.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 2rem; padding: 1rem; border-radius: 8px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="fa-solid fa-circle-exclamation" style="margin-right: 0.5rem;"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card" style="padding: 2rem;">
        <form action="{{ route('dashboard.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                
                {{-- Name (Editable) --}}
                <div>
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email (Read Only) --}}
                <div>
                    <label class="form-label" for="email">Email Address <span style="color: var(--muted); font-size: 0.75rem; font-weight: normal; margin-left: 0.5rem;">(Cannot be changed)</span></label>
                    <input type="email" id="email" class="form-input" value="{{ $user->email }}" readonly style="background: var(--bg-soft); color: var(--muted); cursor: not-allowed;">
                </div>

                {{-- Phone --}}
                <div>
                    @if($user->phone_updates < 2)
                        <label class="form-label" for="phone">Phone Number <span style="color: var(--muted); font-size: 0.75rem; font-weight: normal; margin-left: 0.5rem;">({{ 2 - $user->phone_updates }} updates remaining)</span></label>
                        <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number" maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                        @error('phone')
                            <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    @else
                        <label class="form-label" for="phone">Phone Number <span style="color: var(--muted); font-size: 0.75rem; font-weight: normal; margin-left: 0.5rem;">(Cannot be changed, limit reached)</span></label>
                        <input type="text" id="phone" class="form-input" value="{{ $user->phone ?? 'Not provided' }}" readonly style="background: var(--bg-soft); color: var(--muted); cursor: not-allowed;">
                    @endif
                </div>

                {{-- Address (Editable) --}}
                <div>
                    <label class="form-label" for="address">Residential Address</label>
                    <textarea name="address" id="address" class="form-input" rows="4" placeholder="Enter your full residential address...">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem; text-align: right;">
                <button type="submit" class="btn btn-teal"><i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
