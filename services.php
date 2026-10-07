<?php
$pageTitle = 'Services | Click Slick Auto Detailing';
$pageDescription = 'Explore premium detailing services including interior, exterior, full detail, maintenance, and custom packages.';
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <div class="text-center reveal">
            <h1 class="section-title">Our Detailing Services</h1>
            <p class="section-subtitle mx-auto">Every service is tailored to your vehicle and the results you want to see.</p>
        </div>
        <div class="row g-4 mt-3">
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
                            <a href="./booking.php" class="link-arrow">Book Now <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
