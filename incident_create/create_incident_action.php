<?php
// incident_create/create_incident_action.php
// Purpose:
// 1) Validate form data
// 2) Insert incident into DB
// 3) Redirect back with a success message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/incident_db.php');

$customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
$title       = trim((string) filter_input(INPUT_POST, 'title'));
$description = trim((string) filter_input(INPUT_POST, 'description'));
$email       = trim((string) filter_input(INPUT_POST, 'email'));

if (!$customer_id || !$product_id || $email === '') {
    $error_message = 'Invalid customer or product.';
    include('../errors/error.php');
    exit();
}

// Basic validation: title and description required
if ($title === '' || $description === '') {
    $message = 'Title and Description are required.';
    header('Location: create_incident.php?email=' . urlencode($email) . '&message=' . urlencode($message));
    exit();
}

// Insert incident
add_incident($customer_id, $product_id, $title, $description);

$message = 'Incident was created successfully.';
header('Location: create_incident.php?email=' . urlencode($email) . '&message=' . urlencode($message));
exit();