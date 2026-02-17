<?php
// Load DB connection and technician functions
require_once('../model/database.php');
require_once('../model/technician_db.php');

// Get form values
$firstName = trim($_POST['firstName']);
$lastName  = trim($_POST['lastName']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone']);
$password  = trim($_POST['password']);

// Validation: all fields required
if ($firstName === '' || $lastName === '' ||
    $email === '' || $phone === '' || $password === '') {

    $error_message = 'All fields are required.';
    include('../errors/error.php');
    exit();
}

// Insert technician
add_technician($firstName, $lastName, $email, $phone, $password);

// Redirect back to technician list
header('Location: index.php');
exit();