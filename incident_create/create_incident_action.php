<?php
// incident_create/create_incident_action.php
// Purpose:
// 1) Validate form data (customerID, productID, title, description)
// 2) product must be registered to the customer
// 3) Insert incident into DB
// 4) Redirect back with a success message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/incident_db.php');
require_once('../model/product_db.php'); // for is_product_registered_to_customer()

$customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
$title       = trim((string) filter_input(INPUT_POST, 'title'));
$description = trim((string) filter_input(INPUT_POST, 'description'));
$email       = trim((string) filter_input(INPUT_POST, 'email'));

// Basic validation
if (!$customer_id || !$product_id || $email === '') {
    $error_message = 'Invalid customer or product.';
    include('../errors/error.php');
    exit();
}

// Require title and description
if ($title === '' || $description === '') {
    $message = 'Title and Description are required.';
    header('Location: create_incident.php?email=' . urlencode($email) . '&message=' . urlencode($message));
    exit();
}

// Only allow incidents for products that the customer registered
if (!is_product_registered_to_customer($customer_id, $product_id)) {
    $error_message = 'Invalid product selection. Please choose a registered product.';
    include('../errors/error.php');
    exit();
}

// Insert incident
add_incident($customer_id, $product_id, $title, $description);

// Redirect back with success message
$message = 'Incident was created successfully.';
header('Location: create_incident.php?email=' . urlencode($email) . '&message=' . urlencode($message));
exit();