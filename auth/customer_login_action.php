<?php
// auth/customer_login_action.php
// Purpose: Validate customer email + password, start customer session, redirect

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/database.php');
require_once('../model/customer_db.php');

$email    = trim((string) filter_input(INPUT_POST, 'email'));
$password = trim((string) filter_input(INPUT_POST, 'password'));
$redirect = trim((string) filter_input(INPUT_POST, 'redirect')) ?: '../customer_portal/index.php';

// Validate
if ($email === '' || $password === '') {
    header('Location: portal.php?tab=customer&error=' . urlencode('Please enter email and password.') . '&redirect=' . urlencode($redirect));
    exit();
}

// Lookup customer (email + password)
$customer = get_customer_by_email_password($email, $password);

if (!$customer) {
    header('Location: portal.php?tab=customer&error=' . urlencode('Invalid login. Please try again.') . '&redirect=' . urlencode($redirect));
    exit();
}

// Save session
$_SESSION['is_customer']    = true;
$_SESSION['customer_id']    = (int)$customer['customerID'];
$_SESSION['customer_email'] = (string)$customer['email'];
$_SESSION['customer_name']  = trim($customer['firstName'] . ' ' . $customer['lastName']);

// Redirect back to where the user was trying to go
header('Location: ' . $redirect);
exit();