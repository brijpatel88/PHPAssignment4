<?php
// technician_manager/add_technician.php
// Purpose:
// - Require admin login
// - Validate input
// - Add technician using OOP DB layer (Project 14-1)

require_once('../util/require_login.php');
require_login('../');

require_once('../model/technician_db_oo.php');

// Safely read input
$firstName = trim((string) filter_input(INPUT_POST, 'firstName'));
$lastName  = trim((string) filter_input(INPUT_POST, 'lastName'));
$email     = trim((string) filter_input(INPUT_POST, 'email'));
$phone     = trim((string) filter_input(INPUT_POST, 'phone'));
$password  = trim((string) filter_input(INPUT_POST, 'password'));

// Basic validation (Project 6-2 requirement)
if ($firstName === '' || $lastName === '' || $email === '' || $phone === '' || $password === '') {
    $error_message = 'All fields are required.';
    include('../errors/error.php');
    exit();
}

// Add technician (OOP layer)
add_technician_oo($firstName, $lastName, $email, $phone, $password);

// Redirect back to list
header('Location: index.php');
exit();