<?php
$pageTitle = 'Contact | Click Slick Auto Detailing';
$pageDescription = 'Call or text Click Slick Auto Detailing to schedule your next detailing service.';
require_once __DIR__ . '/includes/database.php';
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <div class="text-center reveal" id="contact-options">
            <span class="eyebrow">Contact / Book Through Contact</span>
            <h1 class="section-title">Ready to Get Your Car Looking Its Best?</h1>
            <p class="section-subtitle mx-auto">Ready to book? Call or text us and we'll help you schedule your detailing service.</p>
            <div class="contact-actions">
                <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>" class="btn btn-primary"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call <?php echo htmlspecialchars($siteConfig['phone']); ?></a>
                <a href="<?php echo htmlspecialchars($siteConfig['sms_href']); ?>" class="btn btn-secondary"><i class="fa-solid fa-comment-sms" aria-hidden="true"></i> Text Us</a>
            </div>
            <p class="contact-phone">Call us at <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>"><?php echo htmlspecialchars($siteConfig['phone']); ?></a></p>
            <p class="contact-hours">Business hours: <?php echo htmlspecialchars($siteConfig['business_hours']); ?></p>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-lg-8 mx-auto reveal">
                <div class="contact-card">
                    <ul class="contact-list">
                        <li><i class="fa-solid fa-phone" aria-hidden="true"></i><div><strong>Phone</strong><a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>"><?php echo htmlspecialchars($siteConfig['phone']); ?></a></div></li>
                        <li><i class="fa-solid fa-envelope" aria-hidden="true"></i><div><strong>Email</strong><a href="mailto:<?php echo htmlspecialchars($siteConfig['email']); ?>"><?php echo htmlspecialchars($siteConfig['email']); ?></a></div></li>
                        <li><i class="fa-solid fa-location-dot" aria-hidden="true"></i><div><strong>Service Area</strong><span><?php echo htmlspecialchars($siteConfig['location']); ?></span></div></li>
                        <li><i class="fa-solid fa-clock" aria-hidden="true"></i><div><strong>Business Hours</strong><span><?php echo htmlspecialchars($siteConfig['business_hours']); ?></span></div></li>
                    </ul>
                </div>
            </div>
        </div>

        <section class="location-section contact-location" id="location">
            <div class="location-panel">
                <span class="eyebrow">Location</span>
                <h2>Click Slick Auto Detailing</h2>
                <p class="location-intro">Find us in Tucson, Arizona. Mobile detailing is also available throughout the area by appointment.</p>
                <ul class="contact-list location-details">
                    <li><i class="fa-solid fa-location-dot" aria-hidden="true"></i><div><strong>Our Location</strong><span><?php echo htmlspecialchars($siteConfig['location']); ?></span></div></li>
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
        </section>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
