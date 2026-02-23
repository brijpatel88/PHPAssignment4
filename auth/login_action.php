<?php
// auth/login_action.php
// Purpose: Validate admin login, then start session and redirect.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/auth.php');

$email    = trim((string) filter_input(INPUT_POST, 'email'));
$password = trim((string) filter_input(INPUT_POST, 'password'));
$redirect = trim((string) filter_input(INPUT_POST, 'redirect')) ?: '../index.php';

// Basic validation
if ($email === '' || $password === '') {
    header('Location: login.php?error=' . urlencode('Please enter email and password.') . '&redirect=' . urlencode($redirect));
    exit();
}

// Check credentials
if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
    $_SESSION['is_admin'] = true;
    $_SESSION['admin_email'] = $email;

    header('Location: ' . $redirect);
    exit();
}

// Wrong credentials
header('Location: login.php?error=' . urlencode('Invalid login. Try again.') . '&redirect=' . urlencode($redirect));
exit();