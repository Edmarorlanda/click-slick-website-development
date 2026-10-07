<?php
$pageTitle = 'Reviews | Click Slick Auto Detailing';
$pageDescription = 'Read what customers say about the detailing experience and results from Click Slick Auto Detailing.';
$reviewMessage = null;
$reviewError = null;
require_once __DIR__ . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['review_name'] ?? ''));
    $email = trim((string) ($_POST['review_email'] ?? ''));
    $message = trim((string) ($_POST['review_message'] ?? ''));
    $rating = (int) ($_POST['rating'] ?? 0);

    if (!verify_csrf()) {
        $reviewError = 'Your session expired. Please refresh the page and try again.';
    } elseif ($name === '' || $message === '' || $rating < 1 || $rating > 5) {
        $reviewError = 'Please provide your name, rating, and review.';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $reviewError = 'Please enter a valid email address.';
    } else {
        try {
            $statement = db()->prepare('INSERT INTO reviews (reviewer_name, reviewer_email, rating, message) VALUES (?, ?, ?, ?)');
            $statement->execute([$name, $email ?: null, $rating, $message]);
            $reviewMessage = 'Thank you. Your review has been submitted for approval.';
            $_POST = [];
        } catch (Throwable $exception) {
            $reviewError = 'We could not save your review right now. Please try again.';
        }
    }
}

$approvedReviews = [];
try {
    $approvedReviews = db()->query("SELECT reviewer_name AS author, message AS quote, rating FROM reviews WHERE status = 'approved' ORDER BY created_at DESC")->fetchAll();
} catch (Throwable $exception) {
    $approvedReviews = [];
}
if ($approvedReviews) {
    $testimonials = $approvedReviews;
}
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <?php if ($reviewMessage): ?><div class="alert alert-success" role="status"><?php echo e($reviewMessage); ?></div><?php endif; ?>
        <?php if ($reviewError): ?><div class="alert alert-danger" role="alert"><?php echo e($reviewError); ?></div><?php endif; ?>
        <div class="text-center reveal">
            <h1 class="section-title">What Our Customers Say</h1>
            <p class="section-subtitle mx-auto">Real customers. Real vehicles. Real results.</p>
        </div>
        <div class="review-grid mt-4" id="all-reviews">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="review-card reveal">
                    <div class="quote-icon"><i class="fa-solid fa-quote-right"></i></div>
                    <span class="stars">★★★★★</span>
                    <p>“<?php echo htmlspecialchars($testimonial['quote']); ?>”</p>
                    <h4>— <?php echo htmlspecialchars($testimonial['author']); ?></h4>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="saved-review-note" id="saved-review-note" hidden>Your submitted reviews appear here on this browser.</p>

        <div class="review-form-shell reveal">
            <div class="review-form-intro">
                <span class="eyebrow">Share your experience</span>
                <h2>Tell others about your experiences</h2>
                <p>Your feedback helps future customers know what to expect from Click Slick.</p>
            </div>
            <form id="review-form" class="review-form" method="post" action="./reviews.php">
                <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="review-name">Your Name</label>
                        <input id="review-name" name="review_name" type="text" class="form-control" placeholder="Your name" required>
                    </div>
                    <div class="form-group">
                        <label for="review-email">Email <span class="optional-label">(optional)</span></label>
                        <input id="review-email" name="review_email" type="email" class="form-control" placeholder="you@example.com">
                    </div>
                    <div class="form-group full">
                        <fieldset class="rating-fieldset">
                            <legend>Rate your experience</legend>
                            <div class="star-rating" role="radiogroup" aria-label="Rating from one to five stars">
                                <?php for ($rating = 5; $rating >= 1; $rating--): ?>
                                    <input type="radio" id="rating-<?php echo $rating; ?>" name="rating" value="<?php echo $rating; ?>" required>
                                    <label for="rating-<?php echo $rating; ?>" title="<?php echo $rating; ?> stars"><i class="fa-solid fa-star"></i><span class="visually-hidden"><?php echo $rating; ?> stars</span></label>
                                <?php endfor; ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group full">
                        <label for="review-message">Your Review</label>
                        <textarea id="review-message" name="review_message" rows="5" placeholder="Tell others about your experience..." required></textarea>
                    </div>
                </div>
                <div class="review-form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Submit Review</button>
                    <p class="review-note">Reviews are submitted for review before being published.</p>
                </div>
                <div class="review-confirmation" hidden role="status">
                    <i class="fa-solid fa-circle-check"></i>
                    <div><strong>Thank you for rating Click Slick!</strong><br>Your review has been received and will be reviewed before publishing.</div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
