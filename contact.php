<?php
$pageTitle = 'Contact | Click Slick Auto Detailing';
$pageDescription = 'Contact Click Slick Auto Detailing to schedule your next detailing service.';
$contactMessage = null;
$contactError = null;
require_once __DIR__ . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['contact_name'] ?? ''));
    $email = trim((string) ($_POST['contact_email'] ?? ''));
    $phone = trim((string) ($_POST['contact_phone'] ?? ''));
    $message = trim((string) ($_POST['contact_message'] ?? ''));

    if (!verify_csrf()) {
        $contactError = 'Your session expired. Please refresh the page and try again.';
    } elseif ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contactError = 'Please provide your name, a valid email, and a message.';
    } else {
        try {
            $statement = db()->prepare('INSERT INTO contact_messages (full_name, email, phone, message) VALUES (?, ?, ?, ?)');
            $statement->execute([$name, $email, $phone ?: null, $message]);
            $contactMessage = 'Thanks for reaching out. We will get back to you soon.';
            $_POST = [];
        } catch (Throwable $exception) {
            $contactError = 'We could not save your message right now. Please try again.';
        }
    }
}
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <?php if ($contactMessage): ?><div class="alert alert-success" role="status"><?php echo e($contactMessage); ?></div><?php endif; ?>
        <?php if ($contactError): ?><div class="alert alert-danger" role="alert"><?php echo e($contactError); ?></div><?php endif; ?>
        <div class="text-center reveal">
            <h1 class="section-title">Contact Click Slick</h1>
            <p class="section-subtitle mx-auto">We’re here to help you schedule a detail that fits your vehicle and your schedule.</p>
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
                                <strong>Service Area</strong>
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
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 reveal">
                <div class="contact-card w-100">
                    <h3>Send a Message</h3>
                    <form method="post" action="./contact.php" class="mt-3">
                        <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="form-group mb-3"><label for="contact-name">Name</label><input id="contact-name" name="contact_name" class="form-control" required value="<?php echo e($_POST['contact_name'] ?? ''); ?>"></div>
                        <div class="form-group mb-3"><label for="contact-email">Email</label><input id="contact-email" name="contact_email" type="email" class="form-control" required value="<?php echo e($_POST['contact_email'] ?? ''); ?>"></div>
                        <div class="form-group mb-3"><label for="contact-phone">Phone <span class="optional-label">(optional)</span></label><input id="contact-phone" name="contact_phone" class="form-control" value="<?php echo e($_POST['contact_phone'] ?? ''); ?>"></div>
                        <div class="form-group mb-3"><label for="contact-message">Message</label><textarea id="contact-message" name="contact_message" rows="4" class="form-control" required><?php echo e($_POST['contact_message'] ?? ''); ?></textarea></div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
