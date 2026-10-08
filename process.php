<?php
$pageTitle = 'Our Process | Click Slick Auto Detailing';
$pageDescription = 'See the straightforward process behind Click Slick Auto Detailing service.';
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <div class="text-center reveal">
            <h1 class="section-title">Our Process</h1>
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
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
