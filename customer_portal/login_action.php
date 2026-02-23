<?php
// customer_portal/login_action.php
// Purpose: Validate customer credentials and start customer session.
// Redirects to customer dashboard.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/database.php');
require_once('../model/customer_db.php');

$email    = trim((string) filter_input(INPUT_POST, 'email'));
$password = trim((string) filter_input(INPUT_POST, 'password'));
$redirect = trim((string) filter_input(INPUT_POST, 'redirect'));

if ($redirect === '') {
    $redirect = 'index.php'; // customer_portal/index.php
}

if ($email === '' || $password === '') {
    header('Location: ../auth/portal.php?tab=customer&error=' . urlencode('Email and password are required.'));
    exit();
}

$customer = get_customer_by_email_password($email, $password);

if (!$customer) {
    header('Location: ../auth/portal.php?tab=customer&error=' . urlencode('Invalid customer login. Please try again.'));
    exit();
}

// ✅ Save customer session
$_SESSION['is_customer']     = true;
$_SESSION['customer_id']     = (int)$customer['customerID'];
$_SESSION['customer_email']  = (string)$customer['email'];
$_SESSION['customer_name']   = trim($customer['firstName'] . ' ' . $customer['lastName']);

header('Location: ' . $redirect);
exit();