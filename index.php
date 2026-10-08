<?php
$pageTitle = 'Click Slick Auto Detailing | Professional Auto Detailing';
$pageDescription = 'Professional auto detailing focused on exceptional attention to detail, quality results, and convenient service. Call or text Click Slick Auto Detailing to schedule.';
include __DIR__ . '/includes/header.php';
$homepageTestimonials = $testimonials;
try {
    $databaseTestimonials = db()->query("SELECT message AS quote, reviewer_name AS author, rating FROM reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 3")->fetchAll();
    if ($databaseTestimonials) {
        $homepageTestimonials = $databaseTestimonials;
    }
} catch (Throwable $exception) {
    $homepageTestimonials = $testimonials;
}
?>

<main id="top">
    <section class="hero">
        <canvas class="hero-particles" aria-hidden="true"></canvas>
        <span class="hero-light-sweep" aria-hidden="true"></span>
        <div class="container hero-content reveal">
            <div class="badge-pill"><i class="fa-solid fa-shield-check"></i> Professional • Detailed • Convenient</div>
            <h1>Your Car Deserves to Look This Good.</h1>
            <p>Professional auto detailing with meticulous attention to detail — delivered with quality, convenience, and care.</p>
            <div class="hero-actions">
                <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-primary"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call <?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                <a href="<?php echo htmlspecialchars($siteConfig['sms_href']); ?>" class="btn btn-outline-light"><i class="fa-solid fa-comment-sms" aria-hidden="true"></i> Text Us</a>
                <a href="#services" class="btn btn-outline-light">Explore Our Services</a>
            </div>
            <div class="hero-trust"><span></span> Trusted by drivers who care about the finish</div>
        </div>
        <div class="scroll-indicator" aria-hidden="true"></div>
    </section>

    <section class="trust-bar">
        <div class="container">
            <div class="trust-box reveal">
                <div class="stars">★★★★★</div>
                <h3>5-Star Customer Experience</h3>
                <div class="trust-indicators">
                    <span>Professional Service</span>
                    <span>Attention to Detail</span>
                    <span>Mobile Convenience</span>
                    <span>Interior & Exterior Care</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="services">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">Detailing That Goes Beyond Clean</h2>
                <p class="section-subtitle mx-auto">Every service is performed with patience, precision, and attention to the details that make your vehicle stand out.</p>
            </div>
            <div class="row g-4 mt-4">
                <?php foreach ($serviceCards as $card): ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <div class="service-card <?php echo !empty($card['highlight']) ? 'popular' : ''; ?>">
                            <div class="service-icon"><i class="fa-solid <?php echo $card['name'] === 'Interior Detailing' ? 'fa-couch' : ($card['name'] === 'Exterior Detailing' ? 'fa-car-side' : ($card['name'] === 'Full Interior & Exterior Detail' ? 'fa-car-side' : ($card['name'] === 'Maintenance Detail' ? 'fa-wand-sparkles' : 'fa-star'))); ?>" aria-hidden="true"></i></div>
                            <h3><?php echo htmlspecialchars($card['name']); ?></h3>
                            <p><?php echo htmlspecialchars($card['description']); ?></p>
                            <ul class="feature-list">
                                <?php foreach ($card['features'] as $feature): ?>
                                    <li><?php echo htmlspecialchars($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="service-meta">
                                <span class="service-price"><?php echo htmlspecialchars($card['price']); ?></span>
                                <a href="./services.php" class="link-arrow">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container">
            <div class="row align-items-center g-4 reveal">
                <div class="col-lg-8">
                    <h3>Ready to Bring Your Car Back to Life?</h3>
                    <p>Tell us what your vehicle needs and we'll help you choose the right detailing service.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="./contact.php#contact-options" class="btn btn-primary">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="results">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">See the Difference</h2>
                <p class="section-subtitle mx-auto">It's the details that make the difference.</p>
            </div>
            <div class="row g-5 align-items-center mt-2">
                <div class="col-lg-7 reveal">
                    <div class="before-after-wrap before-after-slider">
                        <img class="before-image" src="./assets/images/before.png" alt="Blue car hood before detailing, showing swirl marks and dull paint" loading="lazy">
                        <img class="after-image" src="./assets/images/after.png" alt="Blue car hood after detailing with a glossy, polished finish" loading="lazy">
                        <div class="slider-divider"></div>
                        <div class="slider-handle"><i class="fa-solid fa-arrows-left-right"></i></div>
                    </div>
                </div>
                <div class="col-lg-5 reveal">
                    <div class="story-box">
                        <div class="quote-mark">“</div>
                        <h3>Clean, polished, and refreshed — not just washed.</h3>
                        <p>From interior grime to dusty wheels and dull paint, the goal is to make every surface look and feel cared for.</p>
                        <p class="mt-3">Attention to small details is what sets the finish apart.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="process">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">Our Process</h2>
            </div>
            <div class="row g-4 mt-2">
                <?php
                $processSteps = [
                    ['01', 'Get in Touch', 'Call or text us to discuss your service and find a time that works for you.'],
                    ['02', 'We Arrive', 'For mobile appointments, we come directly to you.'],
                    ['03', 'We Detail', 'Your vehicle receives careful, professional attention from interior to exterior.'],
                    ['04', 'Enjoy the Results', 'Get your vehicle back looking refreshed, clean, and ready to impress.']
                ];
                foreach ($processSteps as $step):
                ?>
                    <div class="col-lg-3 col-md-6 reveal">
                        <div class="process-card" data-step="<?php echo $step[0]; ?>">
                            <h3><?php echo htmlspecialchars($step[1]); ?></h3>
                            <p><?php echo htmlspecialchars($step[2]); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" id="why-us">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">Why Click Slick?</h2>
            </div>
            <div class="row g-4 mt-2">
                <?php
                $whyCards = [
                    ['fa-magnifying-glass', 'Attention to Detail', 'We don’t rush the job. Small details matter.'],
                    ['fa-award', 'Professional Quality', 'Every vehicle receives careful and thorough treatment.'],
                    ['fa-mobile-screen-button', 'Convenient Mobile Service', 'We can come to you, making professional detailing easier to fit into your schedule.'],
                    ['fa-user-check', 'Personalized Service', 'Every vehicle has different needs, so the service can be adjusted accordingly.'],
                    ['fa-eye', 'Quality You Can See', 'The goal is not simply to make your vehicle clean — it’s to make it look and feel refreshed.'],
                    ['fa-heart', 'Customer Satisfaction', 'Our customers consistently highlight the quality of the work and the service experience.']
                ];
                foreach ($whyCards as $card):
                ?>
                    <div class="col-lg-4 col-md-6 reveal">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="fa-solid <?php echo $card[0]; ?>"></i></div>
                            <h3><?php echo htmlspecialchars($card[1]); ?></h3>
                            <p><?php echo htmlspecialchars($card[2]); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 reveal">
                    <div class="about-media">
                        <img src="./assets/images/sample-pic.png" alt="Professional auto detailing process" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6 reveal">
                    <h2 class="section-title">More Than a Detail. It's How We Care for Your Car.</h2>
                    <p class="section-subtitle">At Click Slick Auto Detailing, we believe professional detailing is about more than making a vehicle look clean. It's about taking the time to understand what your vehicle needs, paying attention to the small things, and delivering results you can see and feel.</p>
                    <p class="section-subtitle">From careful interior cleaning to exterior finishing, Ron takes pride in giving every vehicle the attention it deserves.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container reveal">
            <div class="story-box">
                <h3>The Click Slick Difference</h3>
                <p class="lead">Take your time. Pay attention. Do it right.</p>
                <div class="row g-3 mt-2">
                    <?php
                    $diffPoints = ['No rushed detailing', 'Careful inspection', 'Attention to small areas', 'Customer communication', 'Quality-focused work', 'Convenient service'];
                    foreach ($diffPoints as $point):
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-check text-primary"></i><span><?php echo htmlspecialchars($point); ?></span></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="reviews">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle mx-auto">Real customers. Real vehicles. Real results.</p>
            </div>
            <div class="review-grid mt-4">
                <?php foreach (array_slice($homepageTestimonials, 0, 3) as $testimonial): ?>
                    <div class="review-card reveal">
                        <div class="quote-icon"><i class="fa-solid fa-quote-right"></i></div>
                        <span class="stars"><?php echo str_repeat('★', (int) ($testimonial['rating'] ?? 5)); ?></span>
                        <p>“<?php echo htmlspecialchars($testimonial['quote']); ?>”</p>
                        <h4>— <?php echo htmlspecialchars($testimonial['author']); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4 reveal">
                <a href="./reviews.php" class="btn btn-primary"><i class="fa-solid fa-comments" aria-hidden="true"></i> See All Reviews</a>
            </div>
            <div class="review-highlights mt-5 reveal">
                <h3 class="section-title" style="font-size:1.9rem; margin-bottom: 18px;">Customers Love Our:</h3>
                <ul class="highlight-list">
                    <li>Attention to Detail</li>
                    <li>Professional Service</li>
                    <li>Amazing Results</li>
                    <li>Flexibility</li>
                    <li>Mobile Convenience</li>
                    <li>Personalized Care</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 reveal">
                    <div class="mission-card">
                        <span class="eyebrow">Our Mission</span>
                        <h3>To provide reliable, detailed, and customer-focused auto detailing services that help every vehicle look its best while making professional car care convenient and accessible.</h3>
                    </div>
                </div>
                <div class="col-lg-6 reveal">
                    <div class="mission-card" style="background:#f4f8ff; color: var(--dark-blue); border: 1px solid rgba(148,163,184,0.18);">
                        <span class="eyebrow" style="color: var(--gray);">Our Vision</span>
                        <h3 style="color: var(--dark-blue);">To become a trusted name in auto detailing known for exceptional attention to detail, personalized service, and consistently impressive results.</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section location-section" id="location">
        <div class="container">
            <div class="text-center reveal">
                <span class="eyebrow">Location</span>
                <h2 class="section-title">Click Slick Auto Detailing</h2>
                <p class="section-subtitle mx-auto">Visit us in Tucson, Arizona, or ask about convenient mobile detailing by appointment.</p>
            </div>
            <div class="location-card reveal">
                <div class="location-panel">
                    <h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Our Location</h3>
                    <p class="location-intro"><?php echo htmlspecialchars($siteConfig['location']); ?>. Mobile service is available throughout Tucson by appointment.</p>
                    <ul class="contact-list location-details">
                        <li><i class="fa-solid fa-phone" aria-hidden="true"></i><div><strong>Call to Book</strong><a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>"><?php echo htmlspecialchars($siteConfig['phone']); ?></a></div></li>
                        <li><i class="fa-solid fa-clock" aria-hidden="true"></i><div><strong>Business Hours</strong><span><?php echo htmlspecialchars($siteConfig['business_hours']); ?></span></div></li>
                    </ul>
                    <div class="location-actions">
                        <a href="<?php echo htmlspecialchars($siteConfig['directions_url']); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-diamond-turn-right" aria-hidden="true"></i> Get Directions</a>
                        <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-outline-primary"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call <?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                    </div>
                </div>
                <div class="location-map">
                    <iframe title="Map showing Click Slick Auto Detailing in Tucson, Arizona" src="<?php echo htmlspecialchars($siteConfig['map_embed_url']); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <section class="section" id="faq">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">FAQ</h2>
            </div>
            <div class="row mt-4">
                <div class="col-lg-8 offset-lg-2">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?> reveal">
                            <button class="faq-question" type="button">
                                <span><?php echo htmlspecialchars($faq['question']); ?></span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer"><?php echo htmlspecialchars($faq['answer']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">Let's Get Your Car Looking Its Best</h2>
            </div>
            <div class="row g-4 mt-2 align-items-stretch">
                <div class="col-lg-7 reveal">
                    <div class="contact-card">
                        <ul class="contact-list">
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <div>
                                    <strong>Phone</strong>
                                    <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>"><?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <div>
                                    <strong>Email</strong>
                                    <a href="mailto:<?php echo htmlspecialchars($siteConfig['email']); ?>"><?php echo htmlspecialchars($siteConfig['email']); ?></a>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <div>
                                    <strong>Business Location / Service Area</strong>
                                    <span><?php echo htmlspecialchars($siteConfig['location']); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-clock"></i>
                                <div>
                                    <strong>Business Hours</strong>
                                    <span><?php echo htmlspecialchars($siteConfig['business_hours']); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="fa-brands fa-facebook-f"></i>
                                <div>
                                    <strong>Facebook</strong>
                                    <a href="<?php echo htmlspecialchars($siteConfig['facebook_url']); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($siteConfig['facebook']); ?></a>
                                </div>
                            </li>
                            <li>
                                <i class="fa-brands fa-instagram"></i>
                                <div>
                                    <strong>Instagram</strong>
                                    <a href="https://instagram.com" target="_blank" rel="noopener"><?php echo htmlspecialchars($siteConfig['instagram']); ?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 reveal d-flex align-items-stretch">
                    <div class="contact-card w-100 d-flex flex-column justify-content-center">
                        <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-primary mb-3"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call <?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                        <a href="<?php echo htmlspecialchars($siteConfig['sms_href']); ?>" class="btn btn-outline-primary mb-3"><i class="fa-solid fa-comment-sms" aria-hidden="true"></i> Text Us</a>
                        <a href="mailto:<?php echo htmlspecialchars($siteConfig['email']); ?>" class="btn btn-outline-primary"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Send an Email</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container reveal">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h3>LET'S GET YOUR CAR LOOKING ITS BEST</h3>
                    <p>Ready to book your next detailing service? Give us a call or send us a text.</p>
                </div>
                <div class="col-lg-5">
                    <div class="cta-actions">
                        <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-primary"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call <?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                        <a href="<?php echo htmlspecialchars($siteConfig['sms_href']); ?>" class="btn btn-outline-light"><i class="fa-solid fa-comment-sms" aria-hidden="true"></i> Text Us</a>
                        <a href="<?php echo htmlspecialchars($siteConfig['directions_url']); ?>" class="btn btn-outline-light" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Get Directions</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
