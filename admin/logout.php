<?php
require_once __DIR__ . '/../includes/database.php';
unset($_SESSION['admin_id'], $_SESSION['admin_username']);
session_regenerate_id(true);
header('Location: ./login.php');
exit;
