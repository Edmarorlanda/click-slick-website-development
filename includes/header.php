<?php
require_once __DIR__ . '/database.php';
$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = $pageTitle ?? $siteConfig['meta_title'];
$pageDescription = $pageDescription ?? $siteConfig['meta_description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="./assets/images/sample-pic.png">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" href="./assets/images/click.jpg?v=2" sizes="any">
    <link rel="shortcut icon" href="./assets/images/click.jpg?v=2">
    <link rel="apple-touch-icon" href="./assets/images/click.jpg?v=2">
</head>
<body>
<?php include __DIR__ . '/navbar.php'; ?>
