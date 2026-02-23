<?php
// incident_update/login_action.php
// Purpose: Validate technician credentials and start tech session

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/database.php');
require_once('../model/technician_db.php');

$email    = trim((string) filter_input(INPUT_POST, 'email'));
$password = trim((string) filter_input(INPUT_POST, 'password'));
$redirect = trim((string) filter_input(INPUT_POST, 'redirect'));

if ($redirect === '') {
    $redirect = 'incident_list.php';
}

if ($email === '' || $password === '') {
    header('Location: ../auth/portal.php?tab=tech&error=' . urlencode('Email and password are required.'));
    exit();
}

$tech = get_technician_by_email_password($email, $password);

if (!$tech) {
    header('Location: ../auth/portal.php?tab=tech&error=' . urlencode('Invalid technician login. Please try again.'));
    exit();
}

// Save technician session
$_SESSION['tech_id']   = (int)$tech['techID'];
$_SESSION['tech_name'] = trim($tech['firstName'] . ' ' . $tech['lastName']);

header('Location: ' . $redirect);
exit();