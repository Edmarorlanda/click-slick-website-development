document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    const backToTop = document.querySelector('.back-to-top');
    const revealItems = document.querySelectorAll('.reveal');
    const navToggle = document.querySelector('.navbar-toggler');
    const navCollapse = document.querySelector('.navbar-collapse');
    const faqItems = document.querySelectorAll('.faq-item');
    const scrollNav = document.querySelector('[data-scroll-nav]');
    const reviewForm = document.querySelector('#review-form');
    const reviewStorageKey = 'clickSlickCustomerReviews';

    function escapeReviewText(value) {
        return String(value).replace(/[&<>'"]/g, character => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#039;',
            '"': '&quot;'
        }[character]));
    }

    function renderSavedReviews() {
        const reviewGrid = document.querySelector('#all-reviews');
        if (!reviewGrid) return;

        reviewGrid.querySelectorAll('.saved-review-card').forEach(card => card.remove());

        let savedReviews = [];
        try {
            savedReviews = JSON.parse(localStorage.getItem(reviewStorageKey) || '[]');
        } catch (error) {
            savedReviews = [];
        }

        savedReviews.forEach(review => {
            const card = document.createElement('div');
            card.className = 'review-card reveal visible saved-review-card';
            const rating = Math.min(5, Math.max(1, Number(review.rating) || 5));
            card.innerHTML = `<div class="quote-icon"><i class="fa-solid fa-quote-right"></i></div>
                <span class="stars">${'★'.repeat(rating)}${'☆'.repeat(5 - rating)}</span>
                <p>“${escapeReviewText(review.message)}”</p>
                <h4>— ${escapeReviewText(review.name)}</h4>`;
            reviewGrid.appendChild(card);
        });

        const note = document.querySelector('#saved-review-note');
        if (note && savedReviews.length) note.hidden = false;
    }

    renderSavedReviews();

    function handleScroll() {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        if (window.scrollY > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    if (scrollNav && (window.location.pathname.endsWith('/index.php') || window.location.pathname.endsWith('/'))) {
        const sectionLinks = Array.from(scrollNav.querySelectorAll('[data-section]'));
        const scrollSections = sectionLinks
            .map(link => ({ link, section: document.getElementById(link.dataset.section) }))
            .filter(item => item.section);

        const updateActiveSection = () => {
            const marker = window.scrollY + (navbar ? navbar.offsetHeight : 80) + 120;
            let current = 'top';

            scrollSections.forEach(item => {
                if (item.section.offsetTop <= marker) {
                    current = item.section.id;
                }
            });

            sectionLinks.forEach(link => {
                link.classList.toggle('active', link.dataset.section === current);
            });
        };

        window.addEventListener('scroll', updateActiveSection, { passive: true });
        updateActiveSection();
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    revealItems.forEach(item => observer.observe(item));

    if (navToggle && navCollapse) {
        navToggle.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            navCollapse.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!navCollapse.classList.contains('show')) return;
            if (navCollapse.contains(event.target) || navToggle.contains(event.target)) return;
            navCollapse.classList.remove('show');
            navToggle.setAttribute('aria-expanded', 'false');
        });
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            if (navCollapse && navCollapse.classList.contains('show')) {
                navCollapse.classList.remove('show');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });

    faqItems.forEach(item => {
        const button = item.querySelector('.faq-question');
        if (!button) return;
        button.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');
            faqItems.forEach(faq => faq.classList.remove('active'));
            if (!isOpen) {
                item.classList.add('active');
            }
        });
    });

    const beforeAfterSlider = document.querySelector('.before-after-slider');
    if (beforeAfterSlider) {
        const afterImage = beforeAfterSlider.querySelector('.after-image');
        const divider = beforeAfterSlider.querySelector('.slider-divider');
        const handle = beforeAfterSlider.querySelector('.slider-handle');
        let dragging = false;

        const updateSlider = (xPos) => {
            const rect = beforeAfterSlider.getBoundingClientRect();
            let percent = ((xPos - rect.left) / rect.width) * 100;
            percent = Math.min(100, Math.max(0, percent));
            afterImage.style.clipPath = `inset(0 0 0 ${percent}%)`;
            divider.style.left = `${percent}%`;
            handle.style.left = `${percent}%`;
        };

        beforeAfterSlider.addEventListener('pointerdown', (event) => {
            dragging = true;
            updateSlider(event.clientX);
        });

        beforeAfterSlider.addEventListener('pointermove', (event) => {
            if (!dragging) return;
            updateSlider(event.clientX);
        });

        beforeAfterSlider.addEventListener('pointerup', () => {
            dragging = false;
        });

        beforeAfterSlider.addEventListener('pointerleave', () => {
            dragging = false;
        });
    }

    const multiStepForm = document.querySelector('.multi-step-form');
    if (multiStepForm) {
        const steps = Array.from(multiStepForm.querySelectorAll('.form-step'));
        const progress = Array.from(multiStepForm.querySelectorAll('.progress-indicator span'));
        const prevBtn = multiStepForm.querySelector('[data-action="prev"]');
        const nextBtn = multiStepForm.querySelector('[data-action="next"]');
        const submitBtn = multiStepForm.querySelector('[data-action="submit"]');
        const form = multiStepForm.querySelector('form');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle('active', i === index);
            });

            progress.forEach((bar, i) => {
                bar.classList.toggle('active', i <= index);
            });

            prevBtn.style.visibility = index === 0 ? 'hidden' : 'visible';
            nextBtn.style.display = index === steps.length - 1 ? 'none' : 'inline-flex';
            submitBtn.style.display = index === steps.length - 1 ? 'inline-flex' : 'none';
        }

        prevBtn?.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep -= 1;
                showStep(currentStep);
            }
        });

        nextBtn?.addEventListener('click', () => {
            const activeFields = steps[currentStep].querySelectorAll('[required]');
            let valid = true;
            activeFields.forEach(field => {
                if (!field.value.trim()) {
                    field.focus();
                    valid = false;
                }
            });
            if (!valid) return;
            currentStep += 1;
            showStep(currentStep);
        });

        showStep(currentStep);
    }

    const mobileServiceCheckbox = document.querySelector('#mobile-service');
    const addressField = document.querySelector('#service-address-wrap');
    if (mobileServiceCheckbox && addressField) {
        const toggleAddress = () => {
            addressField.style.display = mobileServiceCheckbox.checked ? 'block' : 'none';
        };
        mobileServiceCheckbox.addEventListener('change', toggleAddress);
        toggleAddress();
    }

    const sectionLinks = document.querySelectorAll('a[href^="#"]');
    sectionLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;
            const section = document.querySelector(targetId);
            if (!section) return;
            e.preventDefault();
            section.scrollIntoView({ behavior: 'smooth' });
        });
    });

    backToTop?.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
