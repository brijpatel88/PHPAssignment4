<?php
// incident_create/create_incident_action.php
// Purpose:
// - Customer must be logged in
// - Validate form
// - Ensure product belongs to customer registrations
// - Insert incident
// - Redirect back with message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../util/require_customer_login.php');
require_customer_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');
require_once('../model/product_db.php'); // is_product_registered_to_customer()

$customer_id = (int)($_SESSION['customer_id'] ?? 0);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
$title       = trim((string) filter_input(INPUT_POST, 'title'));
$description = trim((string) filter_input(INPUT_POST, 'description'));

if ($customer_id <= 0 || !$product_id) {
    $error_message = 'Invalid customer or product.';
    include('../errors/error.php');
    exit();
}

if ($title === '' || $description === '') {
    header('Location: create_incident.php?message=' . urlencode('Title and Description are required.'));
    exit();
}

if (!is_product_registered_to_customer($customer_id, $product_id)) {
    $error_message = 'Invalid product selection. Please choose a registered product.';
    include('../errors/error.php');
    exit();
}

// IMPORTANT: this function must exist in model/incident_db.php
// add_incident($customer_id, $product_id, $title, $description);
add_incident($customer_id, $product_id, $title, $description);

header('Location: create_incident.php?message=' . urlencode('Incident was created successfully.'));
exit();