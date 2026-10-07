<?php
$pageTitle = 'Book Your Detail | Click Slick Auto Detailing';
$pageDescription = 'Request an appointment for your auto detailing service.';
$bookingMessage = null;
$bookingError = null;
require_once __DIR__ . '/includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['full_name', 'phone', 'email', 'vehicle_make', 'vehicle_model', 'vehicle_year', 'vehicle_type', 'vehicle_color', 'service_type', 'preferred_date', 'preferred_time', 'service_location'];
    $missing = array_filter($required, static fn($field) => trim((string) ($_POST[$field] ?? '')) === '');

    if (!verify_csrf()) {
        $bookingError = 'Your session expired. Please refresh the page and try again.';
    } elseif ($missing) {
        $bookingError = 'Please complete all required booking fields.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $bookingError = 'Please enter a valid email address.';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['preferred_date']) || $_POST['preferred_date'] < date('Y-m-d')) {
        $bookingError = 'Please choose a valid future appointment date.';
    } elseif (!preg_match('/^\d{2}:\d{2}$/', $_POST['preferred_time'])) {
        $bookingError = 'Please choose a valid appointment time.';
    } else {
        try {
            $duplicate = db()->prepare("SELECT COUNT(*) FROM bookings WHERE preferred_date = ? AND preferred_time = ? AND status <> 'cancelled'");
            $duplicate->execute([$_POST['preferred_date'], $_POST['preferred_time'] . ':00']);
            if ((int) $duplicate->fetchColumn() > 0) {
                $bookingError = 'That appointment time is already requested. Please choose another time.';
            } else {
                $statement = db()->prepare("INSERT INTO bookings (full_name, phone, email, vehicle, vehicle_make, vehicle_model, vehicle_year, vehicle_type, vehicle_color, service, preferred_date, preferred_time, location, service_location, service_address, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new')");
                $statement->execute([
                    trim($_POST['full_name']), trim($_POST['phone']), trim($_POST['email']),
                    trim($_POST['vehicle_make']) . ' ' . trim($_POST['vehicle_model']),
                    trim($_POST['vehicle_make']), trim($_POST['vehicle_model']), (int) $_POST['vehicle_year'],
                    trim($_POST['vehicle_type']), trim($_POST['vehicle_color']), trim($_POST['service_type']),
                    $_POST['preferred_date'], $_POST['preferred_time'] . ':00', trim($_POST['service_location']),
                    trim($_POST['service_location']), trim($_POST['service_address'] ?? ''), trim($_POST['notes'] ?? '')
                ]);
                $bookingMessage = 'Your booking request has been received. We will contact you to confirm your appointment.';
                $_POST = [];
            }
        } catch (Throwable $exception) {
            $bookingError = 'We could not save your booking right now. Please try again.';
        }
    }
}
include __DIR__ . '/includes/header.php';
?>
<main class="section inner-page">
    <div class="container">
        <?php if ($bookingMessage): ?><div class="alert alert-success" role="status"><?php echo e($bookingMessage); ?></div><?php endif; ?>
        <?php if ($bookingError): ?><div class="alert alert-danger" role="alert"><?php echo e($bookingError); ?></div><?php endif; ?>
        <div class="text-center reveal">
            <h1 class="section-title">Book Your Detail</h1>
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
                                <div id="service-address-wrap" class="form-group full" style="display:none;">
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
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
