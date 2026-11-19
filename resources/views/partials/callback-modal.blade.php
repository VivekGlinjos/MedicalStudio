{{-- Callback Modal — shown once per session --}}
<div id="callbackModal"
     x-data="{ show: false }"
     x-init="
        if (!sessionStorage.getItem('ms_modal_shown')) {
            setTimeout(() => { show = true; sessionStorage.setItem('ms_modal_shown', '1'); }, 4000);
        }
     "
     x-show="show"
     x-transition:enter="fade-in"
     style="display:none;">

    <div class="modal-overlay" @click.self="show = false">
        <div class="modal-box" x-transition:enter="slide-up">

            <button class="modal-close" @click="show = false" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div style="text-align:center; margin-bottom:1.5rem;">
                <div style="width:60px;height:60px;border-radius:50%;background:#FEE2E2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i class="fa-solid fa-user-doctor" style="font-size:1.5rem;color:#DC2626;"></i>
                </div>
                <h2 class="modal-title">Get Free Counselling Guidance</h2>
                <p class="modal-subtitle">Our Admissions expert will call you within 24 hours — free of charge.</p>
            </div>

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="modal_name">Your Name *</label>
                    <input type="text" id="modal_name" name="name" class="form-input" placeholder="Dr. / Candidate Name" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="modal_course">Target Course / Branch</label>
                    <input type="text" id="modal_course" name="course" class="form-input" placeholder="e.g. MBBS, BDS, MD Radiology, MS Surgery">
                </div>
                <div class="form-group">
                    <label class="form-label" for="modal_phone">Phone / WhatsApp *</label>
                    <input type="tel" id="modal_phone" name="phone" class="form-input" placeholder="+91 XXXXX XXXXX" required maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                </div>
                <button type="submit" class="btn btn-primary w-full" style="width:100%;justify-content:center;">
                    <i class="fa-solid fa-paper-plane"></i>
                    Request Callback
                </button>
                <p style="text-align:center;font-size:0.75rem;color:#8B95A1;margin-top:0.75rem;">
                    <i class="fa-solid fa-lock" style="color:#DC2626;"></i>
                    Your data is 100% private. No spam, guaranteed.
                </p>
            </form>
        </div>
    </div>
</div>
