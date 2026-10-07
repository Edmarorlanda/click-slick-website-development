<footer class="site-footer">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="./assets/images/click.jpg" alt="Click Slick logo" class="footer-logo" loading="lazy">
                    <h3>CLICK SLICK AUTO DETAILING</h3>
                    <p><?php echo $siteConfig['tagline']; ?></p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="footer-links-wrap">
                    <div class="footer-links">
                        <a href="./index.php">Home</a>
                        <a href="./services.php">Services</a>
                        <a href="./about.php">About</a>
                        <a href="./process.php">Process</a>
                    </div>
                    <div class="footer-links">
                        <a href="./reviews.php">Reviews</a>
                        <a href="./booking.php">Booking</a>
                        <a href="./contact.php">Contact</a>
                        <a href="./index.php#faq">FAQ</a>
                    </div>
                    <div class="footer-contact">
                        <a href="<?php echo htmlspecialchars($siteConfig['phone_href']); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><?php echo $siteConfig['phone']; ?></span></a>
                        <a href="mailto:<?php echo $siteConfig['email']; ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span><?php echo $siteConfig['email']; ?></span></a>
                        <div class="social-links">
                            <a href="<?php echo htmlspecialchars($siteConfig['facebook_url']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Click Slick Auto Detailing. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<a href="#top" class="back-to-top" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/script.js"></script>
</body>
</html>
