<?php
require_once __DIR__ . '/../includes/database.php';
if (empty($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $type = $_POST['type'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($type === 'booking') {
        $status = $_POST['status'] ?? 'new';
        if (in_array($status, ['new', 'confirmed', 'completed', 'cancelled'], true)) {
            $statement = db()->prepare('UPDATE bookings SET status = ? WHERE id = ?');
            $statement->execute([$status, $id]);
        }
    } elseif ($type === 'review') {
        $status = $_POST['status'] ?? 'pending';
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $statement = db()->prepare('UPDATE reviews SET status = ? WHERE id = ?');
            $statement->execute([$status, $id]);
        }
    } elseif ($type === 'message') {
        $status = $_POST['status'] ?? 'new';
        if (in_array($status, ['new', 'read', 'archived'], true)) {
            $statement = db()->prepare('UPDATE contact_messages SET status = ? WHERE id = ?');
            $statement->execute([$status, $id]);
        }
    }
    header('Location: ./index.php');
    exit;
}

$bookings = db()->query('SELECT * FROM bookings ORDER BY created_at DESC')->fetchAll();
$reviews = db()->query('SELECT * FROM reviews ORDER BY created_at DESC')->fetchAll();
$messages = db()->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
$services = db()->query('SELECT * FROM services ORDER BY name')->fetchAll();
?><!doctype html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard | Click Slick</title><link rel="stylesheet" href="../assets/css/style.css"><style>body{background:#f1f5f9}.admin-wrap{max-width:1280px;margin:auto;padding:48px 20px}.admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}.admin-section{background:#fff;border-radius:18px;padding:24px;margin-bottom:24px;box-shadow:var(--shadow-soft);overflow-x:auto}.admin-table{width:100%;border-collapse:collapse;min-width:760px}.admin-table th,.admin-table td{padding:12px;border-bottom:1px solid #e2e8f0;text-align:left;vertical-align:top}.admin-table th{color:var(--gray);font-size:.82rem;text-transform:uppercase}.admin-table select{min-width:130px;padding:6px}</style></head>
<body><main class="admin-wrap"><div class="admin-header"><div><span class="eyebrow">Click Slick</span><h1 class="section-title mb-0">Admin Dashboard</h1></div><a class="btn btn-primary" href="./logout.php">Sign Out</a></div>
<section class="admin-section"><h2>Bookings</h2><table class="admin-table"><tr><th>Customer</th><th>Vehicle</th><th>Service</th><th>Appointment</th><th>Status</th></tr><?php foreach ($bookings as $booking): ?><tr><td><?php echo e($booking['full_name']); ?><br><?php echo e($booking['phone']); ?><br><?php echo e($booking['email']); ?></td><td><?php echo e($booking['vehicle']); ?></td><td><?php echo e($booking['service']); ?></td><td><?php echo e($booking['preferred_date']); ?> <?php echo e(substr((string) $booking['preferred_time'], 0, 5)); ?><br><?php echo e($booking['location']); ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>"><input type="hidden" name="type" value="booking"><input type="hidden" name="id" value="<?php echo (int) $booking['id']; ?>"><select name="status" onchange="this.form.submit()"><?php foreach (['new','confirmed','completed','cancelled'] as $status): ?><option <?php echo $booking['status'] === $status ? 'selected' : ''; ?>><?php echo $status; ?></option><?php endforeach; ?></select></form></td></tr><?php endforeach; ?></table></section>
<section class="admin-section"><h2>Reviews</h2><table class="admin-table"><tr><th>Reviewer</th><th>Rating</th><th>Message</th><th>Status</th></tr><?php foreach ($reviews as $review): ?><tr><td><?php echo e($review['reviewer_name']); ?><br><?php echo e($review['reviewer_email']); ?></td><td><?php echo str_repeat('★', (int) $review['rating']); ?></td><td><?php echo e($review['message']); ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>"><input type="hidden" name="type" value="review"><input type="hidden" name="id" value="<?php echo (int) $review['id']; ?>"><select name="status" onchange="this.form.submit()"><?php foreach (['pending','approved','rejected'] as $status): ?><option <?php echo $review['status'] === $status ? 'selected' : ''; ?>><?php echo $status; ?></option><?php endforeach; ?></select></form></td></tr><?php endforeach; ?></table></section>
<section class="admin-section"><h2>Contact Messages</h2><table class="admin-table"><tr><th>Sender</th><th>Message</th><th>Status</th></tr><?php foreach ($messages as $message): ?><tr><td><?php echo e($message['full_name']); ?><br><?php echo e($message['email']); ?><br><?php echo e($message['phone']); ?></td><td><?php echo nl2br(e($message['message'])); ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>"><input type="hidden" name="type" value="message"><input type="hidden" name="id" value="<?php echo (int) $message['id']; ?>"><select name="status" onchange="this.form.submit()"><?php foreach (['new','read','archived'] as $status): ?><option <?php echo $message['status'] === $status ? 'selected' : ''; ?>><?php echo $status; ?></option><?php endforeach; ?></select></form></td></tr><?php endforeach; ?></table></section>
<section class="admin-section"><h2>Services</h2><table class="admin-table"><tr><th>Name</th><th>Price</th><th>Active</th></tr><?php foreach ($services as $service): ?><tr><td><?php echo e($service['name']); ?></td><td><?php echo e($service['price_label'] ?: 'Not set'); ?></td><td><?php echo $service['is_active'] ? 'Yes' : 'No'; ?></td></tr><?php endforeach; ?></table></section></main></body></html>
