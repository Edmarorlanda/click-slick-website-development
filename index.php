<?php
$pageTitle = 'Click Slick Auto Detailing | Professional Auto Detailing';
$pageDescription = 'Professional auto detailing focused on exceptional attention to detail, quality results, and convenient service. Book your next detail with Click Slick Auto Detailing.';
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
        <div class="container hero-content reveal">
            <div class="badge-pill"><i class="fa-solid fa-shield-check"></i> Professional • Detailed • Convenient</div>
            <h1>Your Car Deserves to Look This Good.</h1>
            <p>Professional auto detailing with meticulous attention to detail — delivered with quality, convenience, and care.</p>
            <div class="hero-actions">
                <a href="./booking.php" class="btn btn-primary">Book Your Detail</a>
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
                    <a href="./booking.php" class="btn btn-primary">Get a Quote</a>
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
                        <img class="before-image" src="./assets/images/sample-pic.png" alt="Before car detailing transformation" loading="lazy">
                        <img class="after-image" src="./assets/images/sample-pic.png" alt="After car detailing transformation" loading="lazy">
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
                    ['01', 'Book', 'Choose your service and preferred appointment time.'],
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

    <section class="section" id="booking">
        <div class="container">
            <div class="text-center reveal">
                <h2 class="section-title">Book Your Detail</h2>
                <p class="section-subtitle mx-auto">Tell us about your vehicle and what it needs. We'll take care of the rest.</p>
            </div>
            <div class="booking-form-shell multi-step-form reveal">
                <div class="booking-header">
                    <h3>Your Detail Request</h3>
                    <div class="progress-indicator">
                        <span class="active"></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="booking-body">
                    <form method="post" action="./booking.php">
                        <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="form-step active">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="vehicle-make">Vehicle Make</label>
                                    <input id="vehicle-make" name="vehicle_make" type="text" class="form-control" placeholder="Toyota" required>
                                </div>
                                <div class="form-group">
                                    <label for="vehicle-model">Vehicle Model</label>
                                    <input id="vehicle-model" name="vehicle_model" type="text" class="form-control" placeholder="Camry" required>
                                </div>
                                <div class="form-group">
                                    <label for="vehicle-year">Vehicle Year</label>
                                    <input id="vehicle-year" name="vehicle_year" type="number" min="1900" max="2100" class="form-control" placeholder="2022" required>
                                </div>
                                <div class="form-group">
                                    <label for="vehicle-type">Vehicle Type</label>
                                    <select id="vehicle-type" name="vehicle_type" class="form-select" required>
                                        <option value="">Select one</option>
                                        <option>Car</option>
                                        <option>SUV</option>
                                        <option>Truck</option>
                                        <option>Luxury Vehicle</option>
                                        <option>Sports Car</option>
                                    </select>
                                </div>
                                <div class="form-group full">
                                    <label for="vehicle-color">Vehicle Color</label>
                                    <input id="vehicle-color" name="vehicle_color" type="text" class="form-control" placeholder="Blue, black, silver..." required>
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="form-grid">
                                <div class="form-group full">
                                    <label for="service-type">Service</label>
                                    <select id="service-type" name="service_type" class="form-select" required>
                                        <option value="">Choose a service</option>
                                        <?php foreach ($serviceOptions as $option): ?>
                                            <option><?php echo htmlspecialchars($option); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group full">
                                    <label for="service-notes">Additional Details</label>
                                    <textarea id="service-notes" name="notes" rows="4" placeholder="Pet hair, stains, heavy dirt, scratches, etc."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="preferred-date">Preferred Date</label>
                                    <input id="preferred-date" name="preferred_date" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="preferred-time">Preferred Time</label>
                                    <input id="preferred-time" name="preferred_time" type="time" class="form-control" required>
                                </div>
                                <div class="form-group full">
                                    <label for="service-location">Service Location</label>
                                    <select id="service-location" name="service_location" class="form-select" required>
                                        <option value="">Choose location type</option>
                                        <option>In-Shop</option>
                                        <option>Mobile Service</option>
                                    </select>
                                </div>
                                <div class="form-group full" id="service-address-wrap" style="display:none;">
                                    <label for="service-address">Service Address</label>
                                    <input id="service-address" name="service_address" type="text" class="form-control" placeholder="Street address for mobile detailing">
                                </div>
                                <div class="form-group full">
                                    <label class="checkbox-row">
                                        <input type="checkbox" id="mobile-service" name="mobile_service">
                                        <span>Mobile Service</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="full-name">Full Name</label>
                                    <input id="full-name" name="full_name" type="text" class="form-control" placeholder="Your full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone-number">Phone Number</label>
                                    <input id="phone-number" name="phone" type="tel" class="form-control" placeholder="520-710-7339" required>
                                </div>
                                <div class="form-group full">
                                    <label for="email-address">Email</label>
                                    <input id="email-address" name="email" type="email" class="form-control" placeholder="you@example.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="confirmation-box" style="display:none;">
                                <h4>Your booking request has been received.</h4>
                                <p>We'll contact you to confirm your appointment.</p>
                            </div>
                            <div class="form-grid mt-4">
                                <div class="form-group full">
                                    <label>Review your information before submitting.</label>
                                    <p class="step-note">Once you submit, we will follow up to confirm your preferred date and service details.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-light" data-action="prev" style="background:#edf2ff;border:1px solid rgba(29,78,216,0.12);color:var(--dark-blue);">Previous</button>
                            <button type="button" class="btn btn-primary" data-action="next">Next</button>
                            <button type="submit" class="btn btn-primary" data-action="submit" style="display:none;">Request Appointment</button>
                        </div>
                    </form>
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
                        <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-primary mb-3"><i class="fa-solid fa-phone"></i> Call Now</a>
                        <a href="mailto:<?php echo htmlspecialchars($siteConfig['email']); ?>" class="btn btn-primary mb-3"><i class="fa-solid fa-envelope"></i> Send a Message</a>
                        <a href="./booking.php" class="btn btn-primary"><i class="fa-solid fa-calendar-check"></i> Book a Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container reveal">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h3>Your Next Detail Starts Here.</h3>
                    <p>Professional care. Attention to detail. Convenient service.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
