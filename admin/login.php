<?php
require_once __DIR__ . '/../includes/database.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: ./index.php');
    exit;
}
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!verify_csrf()) {
        $error = 'Your session expired. Please try again.';
    } else {
        $statement = db()->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1');
        $statement->execute([$username]);
        $admin = $statement->fetch();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: ./index.php');
            exit;
        }
        $error = 'Invalid username or password.';
    }
}
?><!doctype html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login | Click Slick</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><main class="section inner-page"><div class="container" style="max-width:520px"><div class="contact-card"><h1 class="section-title">Admin Login</h1><?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>"><div class="form-group mb-3"><label for="username">Username</label><input class="form-control" id="username" name="username" required autofocus></div><div class="form-group mb-3"><label for="password">Password</label><input class="form-control" id="password" name="password" type="password" required></div><button class="btn btn-primary" type="submit">Sign In</button></form></div></div></main></body></html>
