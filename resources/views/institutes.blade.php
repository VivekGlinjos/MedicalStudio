@extends('layouts.app')
@section('title', 'Medical Institutes Directory — 1,100+ Colleges | Medical Studio')
@section('content')
<section class="inner-hero" style="padding-top:4rem; padding-bottom:3rem; text-align:center;">
    <div class="container">
        <span class="eyebrow" style="color:var(--blue); font-weight:700; font-size:0.85rem; text-transform:uppercase; letter-spacing:1px;">Free Database</span>
        <h1 class="display-xl" style="color:var(--ink); margin-top:0.75rem; font-family:var(--font-display); font-weight:800; font-size:clamp(2.5rem, 5vw, 4rem); letter-spacing:-0.03em;">Medical Institutes Directory</h1>
        <p style="color:var(--muted);font-size:1.1rem;margin:1rem auto 0;max-width:600px;line-height:1.6;">Browse 1,100+ government and deemed medical colleges. Fee structures, bonds, stipends, and historical closing ranks.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div style="background:var(--bg-soft);border-radius:var(--r-xl);padding:1.5rem;margin-bottom:2rem;display:flex;flex-wrap:wrap;gap:1rem;align-items:center;">
            <input type="text" placeholder="Search college name, city or state..." style="flex:1;min-width:200px;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--r-md);font-size:0.9rem;outline:none;font-family:var(--font-body);" id="collegeSearch">
            <select style="padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--r-md);font-size:0.9rem;outline:none;font-family:var(--font-body);background:white;">
                <option>All Types</option>
                <option>Government</option>
                <option>Deemed University</option>
                <option>Central University</option>
                <option>Private</option>
            </select>
            <select style="padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--r-md);font-size:0.9rem;outline:none;font-family:var(--font-body);background:white;">
                <option>All States</option>
                <option>Delhi</option>
                <option>Maharashtra</option>
                <option>Karnataka</option>
                <option>Tamil Nadu</option>
                <option>UP</option>
            </select>
        </div>

        <div class="alert alert-info" style="margin-bottom:1.5rem;">
            <i class="fa-solid fa-crown"></i>
            <div><strong>Pro Feature:</strong> Full fee structure, monthly stipend, bond years, historical closing ranks and detailed institute profiles are available with a Medical Studio subscription.
            <a href="{{ route('packages') }}" style="color:var(--blue);font-weight:600;">View Packages →</a></div>
        </div>

        <div class="grid-3" id="instituteGrid">
            @php
            $colleges = [
                ['VMMC & Safdarjung Hospital', 'New Delhi', 'Government', 'AIQ', '₹25,000/yr', 'None', '★★★★★'],
                ['ABVIMS & RML Hospital', 'New Delhi', 'Government', 'AIQ', '₹25,000/yr', 'None', '★★★★★'],
                ['BHU Medical College', 'Varanasi, UP', 'Central University', 'AIQ', '₹30,000/yr', '1 year', '★★★★☆'],
                ['AMU – JNMCH', 'Aligarh, UP', 'Central University', 'AIQ', '₹35,000/yr', '1 year', '★★★★☆'],
                ['JIPMER', 'Puducherry', 'Central Institution', 'AIQ', '₹28,000/yr', 'None', '★★★★★'],
                ['Maulana Azad Medical College', 'New Delhi', 'Government', 'AIQ', '₹20,000/yr', 'None', '★★★★★'],
                ['Grant Medical College', 'Mumbai, MH', 'Government', 'State', '₹35,000/yr', '2 years', '★★★★☆'],
                ['Sri Ramachandra University', 'Chennai, TN', 'Deemed', 'Deemed', '₹8,00,000/yr', 'None', '★★★★☆'],
                ['Manipal Hospital', 'Manipal, KA', 'Deemed', 'Deemed', '₹7,50,000/yr', 'None', '★★★★☆'],
                ['KS Hegde Medical Academy', 'Mangalore, KA', 'Deemed', 'Deemed', '₹6,50,000/yr', 'None', '★★★★☆'],
                ['Christian Medical College', 'Vellore, TN', 'Private Aided', 'AIQ', '₹80,000/yr', '5 years', '★★★★★'],
                ['St. Johns Medical College', 'Bengaluru, KA', 'Private Aided', 'AIQ', '₹85,000/yr', '5 years', '★★★★☆'],
            ];
            @endphp
            @foreach($colleges as $c)
            <div class="card college-card" data-name="{{ strtolower($c[0].' '.$c[1]) }}" style="padding:1.5rem;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;">
                    <div>
                        <div style="font-family:var(--font-display);font-weight:700;font-size:0.95rem;color:var(--ink);margin-bottom:0.25rem;">{{ $c[0] }}</div>
                        <div style="font-size:0.8rem;color:var(--muted);">{{ $c[1] }}</div>
                    </div>
                    <span class="badge badge-navy" style="font-size:0.6rem;white-space:nowrap;">{{ $c[2] }}</span>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-bottom:1rem;">
                    <div style="background:var(--bg-soft);border-radius:var(--r-sm);padding:0.5rem;">
                        <div style="font-size:0.65rem;color:var(--muted);text-transform:uppercase;font-weight:600;">Quota</div>
                        <div style="font-size:0.8rem;font-weight:600;color:var(--ink);">{{ $c[3] }}</div>
                    </div>
                    <div style="background:var(--bg-soft);border-radius:var(--r-sm);padding:0.5rem;">
                        <div style="font-size:0.65rem;color:var(--muted);text-transform:uppercase;font-weight:600;">Bond</div>
                        <div style="font-size:0.8rem;font-weight:600;color:var(--ink);">{{ $c[5] }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:0.65rem;color:var(--muted);font-weight:600;text-transform:uppercase;">Annual Fee</div>
                        <div style="font-family:var(--font-display);font-weight:700;font-size:0.95rem;color:var(--red);">{{ $c[4] }}</div>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-ghost-red btn-xs">
                        Full Profile <i class="fa-solid fa-lock" style="font-size:0.6rem;"></i>
                    </a>
                </div>
                <div style="font-size:0.7rem;color:var(--gold);margin-top:0.75rem;">{{ $c[6] }}</div>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:2rem;">
            <div style="background:var(--bg-soft);border:1px dashed var(--border);border-radius:var(--r-xl);padding:2rem;display:inline-block;">
                <i class="fa-solid fa-plus" style="font-size:2rem;color:var(--muted);margin-bottom:0.75rem;display:block;"></i>
                <p style="color:var(--muted);font-size:0.9rem;">1,100+ more colleges available with subscription</p>
                <a href="{{ route('packages') }}" class="btn btn-red btn-sm" style="margin-top:1rem;">
                    <i class="fa-solid fa-crown"></i> Unlock Full Database
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
document.getElementById('collegeSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.college-card').forEach(c => {
        c.closest('.card').style.display = c.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>
@endpush
