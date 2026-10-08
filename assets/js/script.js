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
    const hero = document.querySelector('.hero');
    const particleCanvas = hero?.querySelector('.hero-particles');

    if (hero && particleCanvas && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const context = particleCanvas.getContext('2d');
        if (context) {
            const lowPower = window.matchMedia('(max-width: 767px)').matches
                || (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 4)
                || navigator.connection?.saveData;
            const particleCount = lowPower ? 12 : 34;
            const particles = [];
            let frameId = 0;
            let lastFrame = 0;
            let isVisible = false;
            let isPageVisible = !document.hidden;

            function resizeCanvas() {
                const bounds = hero.getBoundingClientRect();
                const ratio = Math.min(window.devicePixelRatio || 1, lowPower ? 1 : 1.5);
                particleCanvas.width = Math.round(bounds.width * ratio);
                particleCanvas.height = Math.round(bounds.height * ratio);
                particleCanvas.style.width = `${bounds.width}px`;
                particleCanvas.style.height = `${bounds.height}px`;
                context.setTransform(ratio, 0, 0, ratio, 0, 0);
            }

            function seedParticles() {
                particles.length = 0;
                for (let index = 0; index < particleCount; index += 1) {
                    particles.push({
                        x: Math.random() * hero.clientWidth,
                        y: Math.random() * hero.clientHeight,
                        radius: Math.random() * (lowPower ? 1.3 : 1.8) + 0.45,
                        speed: Math.random() * 0.12 + 0.035,
                        drift: (Math.random() - 0.5) * 0.12,
                        alpha: Math.random() * 0.3 + 0.12
                    });
                }
            }

            function drawParticles(time) {
                frameId = 0;
                if (!isVisible || !isPageVisible) return;
                if (time - lastFrame < 32) {
                    frameId = window.requestAnimationFrame(drawParticles);
                    return;
                }
                lastFrame = time;

                const width = hero.clientWidth;
                const height = hero.clientHeight;
                context.clearRect(0, 0, width, height);

                particles.forEach((particle) => {
                    particle.y -= particle.speed;
                    particle.x += particle.drift;
                    if (particle.y < -4) {
                        particle.y = height + 4;
                        particle.x = Math.random() * width;
                    }
                    if (particle.x < -4) particle.x = width + 4;
                    if (particle.x > width + 4) particle.x = -4;

                    context.beginPath();
                    context.fillStyle = `rgba(219, 234, 254, ${particle.alpha})`;
                    context.ellipse(particle.x, particle.y, particle.radius * 0.72, particle.radius, -0.25, 0, Math.PI * 2);
                    context.fill();

                    context.beginPath();
                    context.fillStyle = `rgba(255, 255, 255, ${particle.alpha * 0.65})`;
                    context.arc(particle.x - particle.radius * 0.2, particle.y - particle.radius * 0.28, particle.radius * 0.25, 0, Math.PI * 2);
                    context.fill();
                });

                frameId = window.requestAnimationFrame(drawParticles);
            }

            function updateAnimation() {
                if (isVisible && isPageVisible && !frameId) {
                    frameId = window.requestAnimationFrame(drawParticles);
                } else if ((!isVisible || !isPageVisible) && frameId) {
                    window.cancelAnimationFrame(frameId);
                    frameId = 0;
                }
            }

            resizeCanvas();
            seedParticles();

            const visibilityObserver = new IntersectionObserver((entries) => {
                isVisible = entries[0].isIntersecting;
                updateAnimation();
            });
            visibilityObserver.observe(hero);

            const handleResize = () => {
                resizeCanvas();
                seedParticles();
            };
            const handleVisibility = () => {
                isPageVisible = !document.hidden;
                updateAnimation();
            };

            window.addEventListener('resize', handleResize, { passive: true });
            document.addEventListener('visibilitychange', handleVisibility);
            window.addEventListener('pagehide', () => {
                visibilityObserver.disconnect();
                window.removeEventListener('resize', handleResize);
                document.removeEventListener('visibilitychange', handleVisibility);
                if (frameId) window.cancelAnimationFrame(frameId);
            }, { once: true });
        }
    }

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
            this.classList.toggle('is-open', !expanded);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape' || !navCollapse.classList.contains('show')) return;
            navCollapse.classList.remove('show');
            navToggle.classList.remove('is-open');
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.focus();
        });

        document.addEventListener('click', function (event) {
            if (!navCollapse.classList.contains('show')) return;
            if (navCollapse.contains(event.target) || navToggle.contains(event.target)) return;
            navCollapse.classList.remove('show');
            navToggle.classList.remove('is-open');
            navToggle.setAttribute('aria-expanded', 'false');
        });
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            if (navCollapse && navCollapse.classList.contains('show')) {
                navCollapse.classList.remove('show');
                navToggle.classList.remove('is-open');
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
