/* ============================================================
   MEDICAL STUDIO — app.js v3 (Nextspace White Theme)
   Smooth scrolling · Animations · UI Interactions
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

    /* -------------------------------------------------------
       1. NAVBAR — floating pill scroll effect
    ------------------------------------------------------- */
    const navbar = document.getElementById('mainNavbar');
    if (navbar) {
        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    /* -------------------------------------------------------
       2. SCROLL REVEAL — Intersection Observer
    ------------------------------------------------------- */
    // Generic .reveal elements
    const revealEls = document.querySelectorAll('.reveal');
    if (revealEls.length) {
        const ro = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    ro.unobserve(e.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(el => ro.observe(el));
    }

    // Section animate
    const sectionAnims = document.querySelectorAll('.section-animate');
    if (sectionAnims.length) {
        const so = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('in-view');
                    so.unobserve(e.target);
                }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px -30px 0px' });
        sectionAnims.forEach(el => so.observe(el));
    }

    // Subtle card hover animations — cards gently lift on scroll into view
    const cardEls = document.querySelectorAll('.card, .bcard, .tcard, .ep-card, .pkg-card, .package-card, .institute-card');
    const cardObs = new IntersectionObserver((entries) => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => {
                    e.target.style.opacity = '1';
                    e.target.style.transform = 'translateY(0)';
                }, i * 60);
                cardObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    cardEls.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(16px)';
        el.style.transition = 'opacity 0.5s cubic-bezier(0.16,1,0.3,1), transform 0.5s cubic-bezier(0.16,1,0.3,1)';
        cardObs.observe(el);
    });

    /* -------------------------------------------------------
       3. ANIMATED COUNTER
    ------------------------------------------------------- */
    const counterEls = document.querySelectorAll('[data-target]');
    if (counterEls.length) {
        const co = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    animateCounter(e.target);
                    co.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        counterEls.forEach(el => co.observe(el));
    }

    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-target'), 10);
        const dur = 1800;
        const step = target / (dur / 16);
        let cur = 0;
        const accentHtml = el.innerHTML.match(/<span class="accent">(.+?)<\/span>/);
        const suffix = accentHtml ? accentHtml[1] : '';
        const t = setInterval(() => {
            cur = Math.min(cur + step, target);
            if (suffix) {
                el.innerHTML = Math.floor(cur).toLocaleString('en-IN') + '<span class="accent">' + suffix + '</span>';
            } else if (el.querySelector('.count')) {
                el.querySelector('.count').textContent = Math.floor(cur).toLocaleString('en-IN');
            } else {
                el.textContent = Math.floor(cur).toLocaleString('en-IN');
            }
            if (cur >= target) clearInterval(t);
        }, 16);
    }

    /* -------------------------------------------------------
       4. ACTIVE NAV LINK
    ------------------------------------------------------- */
    const path = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(a => {
        const href = a.getAttribute('href');
        if (href && href !== '#' && (href === path || (path !== '/' && href !== '/' && path.startsWith(href)))) {
            a.classList.add('active');
        }
    });

    /* -------------------------------------------------------
       5. SMOOTH ANCHOR SCROLL
    ------------------------------------------------------- */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = a.getAttribute('href');
            if (target === '#') return;
            const el = document.querySelector(target);
            if (el) {
                e.preventDefault();
                const offset = window.innerHeight * 0.12;
                window.scrollTo({ top: el.getBoundingClientRect().top + scrollY - offset, behavior: 'smooth' });
            }
        });
    });

    /* -------------------------------------------------------
       6. BACK TO TOP BUTTON
    ------------------------------------------------------- */
    const btt = document.createElement('button');
    btt.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
    btt.setAttribute('aria-label', 'Back to top');
    btt.id = 'backToTop';
    Object.assign(btt.style, {
        position: 'fixed', bottom: '96px', right: '28px', zIndex: '400',
        width: '44px', height: '44px', borderRadius: '50%',
        background: '#1d4ed8', color: '#fff', border: 'none',
        cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center',
        fontSize: '0.9rem', boxShadow: '0 4px 16px rgba(29,78,216,0.3)',
        opacity: '0', transform: 'translateY(10px)',
        transition: 'opacity 0.3s ease, transform 0.3s ease', pointerEvents: 'none'
    });
    document.body.appendChild(btt);
    window.addEventListener('scroll', () => {
        const show = window.scrollY > 500;
        btt.style.opacity = show ? '1' : '0';
        btt.style.transform = show ? 'translateY(0)' : 'translateY(10px)';
        btt.style.pointerEvents = show ? 'auto' : 'none';
    }, { passive: true });
    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    btt.addEventListener('mouseenter', () => { btt.style.background = '#1e40af'; btt.style.transform = 'translateY(-2px)'; });
    btt.addEventListener('mouseleave', () => { btt.style.background = '#1d4ed8'; btt.style.transform = 'translateY(0)'; });

    /* -------------------------------------------------------
       7. FAQ ACCORDION
    ------------------------------------------------------- */
    window.toggleFaq = function(btn) {
        const item = btn.closest('.faq-item');
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
        if (!wasOpen) item.classList.add('open');
    };

    // Also support click on .faq-btn
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            item.classList.toggle('open');
        });
    });

    /* -------------------------------------------------------
       8. FEATURE TABS
    ------------------------------------------------------- */
    document.querySelectorAll('.feature-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const container = btn.closest('[data-tabs]') || btn.closest('section') || document;
            container.querySelectorAll('.feature-tab-btn').forEach(b => b.classList.remove('active'));
            container.querySelectorAll('.feature-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            const panel = document.getElementById('tab-' + btn.dataset.tab);
            if (panel) panel.classList.add('active');
        });
    });

    /* -------------------------------------------------------
       9. MOBILE NAV TOGGLE
    ------------------------------------------------------- */
    const navToggle = document.querySelector('.nav-toggle');
    const navMobile = document.querySelector('.nav-mobile');
    if (navToggle && navMobile) {
        // Alpine handles the x-data toggle too, this is a plain JS fallback
        document.addEventListener('click', e => {
            if (!navMobile.contains(e.target) && !navToggle.contains(e.target)) {
                navMobile.classList.remove('open');
            }
        });
    }

    /* -------------------------------------------------------
       10. HOVER LIFT on cards (additional micro-interaction)
    ------------------------------------------------------- */
    document.querySelectorAll('.card, .bcard, .tcard, .ep-card, .pkg-card, .institute-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.willChange = 'transform';
        });
        card.addEventListener('mouseleave', () => {
            card.style.willChange = 'auto';
        });
    });

    /* -------------------------------------------------------
       11. GLOBAL ANIMATIONS (AOS Injector)
    ------------------------------------------------------- */
    const animatedElements = document.querySelectorAll('.card, .reveal, .section-header, .pkg-plan-card, .ms-table-wrapper, .dashboard-grid > div');
    animatedElements.forEach((el, idx) => {
        if (!el.hasAttribute('data-aos')) {
            el.setAttribute('data-aos', 'fade-up');
            // Stagger animations slightly for adjacent elements
            el.setAttribute('data-aos-delay', (idx % 3) * 100);
        }
    });

    /* -------------------------------------------------------
       12. FORM VALIDATION FEEDBACK
    ------------------------------------------------------- */
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (e) => {
            let valid = true;
            form.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#dc2626';
                    field.style.boxShadow = '0 0 0 3px rgba(220,38,38,0.12)';
                    field.addEventListener('input', () => {
                        field.style.borderColor = '';
                        field.style.boxShadow = '';
                    }, { once: true });
                }
            });
            if (!valid) e.preventDefault();
        });
    });

    console.log('Medical Studio v3 — Nextspace White Theme. Initialized.');
});
