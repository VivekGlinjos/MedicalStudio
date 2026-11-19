
<footer class="footer">
    <div class="container">


        <div class="footer-top">


            <div>
                <div class="footer-brand-name">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Medical Studio"
                         class="footer-logo-img"
                         onerror="this.style.display='none'">
                    <span><span class="teal">MEDICAL</span> STUDIO</span>
                </div>
                <p class="footer-tagline">
                    India's trusted platform for medical admissions. Data-driven guidance for MBBS, MD, MS, BDS &amp; MDS — Kerala · Karnataka · Tamil Nadu.
                </p>

                <div class="footer-contact-row">
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+919747500002">+91 97475 00002</a>
                        <span style="color:rgba(255,255,255,.15);">/</span>
                        <a href="tel:+919747500003">+91 97475 00003</a>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:info@medicalstudio.in">info@medicalstudio.in</a>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Mangalore, Karnataka, India</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-brands fa-whatsapp"></i>
                        <a href="https://wa.me/919747500002" target="_blank" rel="noopener">WhatsApp: +91 97475 00002</a>
                    </div>
                </div>

                <div class="footer-socials">
                    <a href="https://www.facebook.com/people/Medical-Studioin/100093274676506/"
                       class="footer-social-btn" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/medicalstudio.in/"
                       class="footer-social-btn" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://youtu.be/nywWWOoPkBs"
                       class="footer-social-btn" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://wa.me/919747500002"
                       class="footer-social-btn" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>


            <div class="footer-col">
                <h5>Admissions</h5>
                <div class="footer-links">
                    <a href="{{ route('counselling.show', 'neet-ug') }}"  class="footer-link">NEET UG 2026</a>
                    <a href="{{ route('counselling.show', 'neet-pg') }}"  class="footer-link">NEET PG 2026</a>
                    <a href="{{ route('counselling.show', 'neet-mds') }}" class="footer-link">NEET MDS 2026</a>
                    <a href="{{ route('counselling.show', 'inicet') }}"   class="footer-link">INICET 2026</a>
                    <a href="{{ route('counselling.show', 'dnb-pdcet') }}" class="footer-link">DNB PDCET 2026</a>
                    <a href="{{ route('counselling.show', 'neet-ss') }}"  class="footer-link">NEET SS 2026</a>
                </div>
            </div>


            <div class="footer-col">
                <h5>Resources</h5>
                <div class="footer-links">
                    <a href="{{ route('institutes') }}"     class="footer-link">Institutes DB</a>
                    <a href="{{ route('seat-predictor') }}" class="footer-link">Seat Predictor</a>
                    <a href="{{ route('features') }}"       class="footer-link">All Tools</a>
                    <a href="{{ route('blog') }}"           class="footer-link">Blog</a>
                    <a href="{{ route('packages') }}"       class="footer-link">Pricing</a>
                </div>
            </div>


            <div class="footer-col">
                <h5>Company</h5>
                <div class="footer-links">
                    <a href="{{ route('about') }}"           class="footer-link">About Us</a>
                    <a href="{{ route('success-stories') }}" class="footer-link">Success Stories</a>
                    <a href="{{ route('contact') }}"         class="footer-link">Contact Us</a>
                    <a href="{{ route('packages') }}"        class="footer-link">Packages</a>
                </div>
            </div>


            <div class="footer-col">
                <h5>Programmes</h5>
                <div class="footer-links">
                    <a href="{{ route('counselling.show', 'neet-ug') }}"  class="footer-link">MBBS</a>
                    <a href="{{ route('counselling.show', 'neet-pg') }}"  class="footer-link">MD / MS</a>
                    <a href="{{ route('counselling.show', 'neet-mds') }}" class="footer-link">BDS / MDS</a>
                    <a href="{{ route('counselling.show', 'inicet') }}"   class="footer-link">AIIMS PG</a>
                </div>
            </div>

        </div>


        <div class="footer-bottom">


            <div class="footer-bottom-links">
                <span class="footer-bottom-copy">© {{ date('Y') }} Medical Studio. All rights reserved.</span>
                <a href="{{ route('privacy-policy') }}" class="footer-bottom-link">Privacy Policy</a>
                <a href="{{ route('refund-policy') }}" class="footer-bottom-link">Refund Policy</a>
                <a href="{{ route('terms-conditions') }}" class="footer-bottom-link">Terms of Use</a>
            </div>


            <div class="footer-bottom-socials">
                <a href="https://www.instagram.com/medicalstudio.in/"
                   class="footer-bottom-social" target="_blank" rel="noopener" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/people/Medical-Studioin/100093274676506/"
                   class="footer-bottom-social" target="_blank" rel="noopener" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/919747500002"
                   class="footer-bottom-social" target="_blank" rel="noopener" aria-label="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>

        </div>
    </div>
</footer>
