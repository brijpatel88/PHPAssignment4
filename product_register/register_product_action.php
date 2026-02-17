<?php
// product_register/register_product_action.php
// Purpose:
// - Receive posted customer + product selection
// - Register product for the customer (registrations table)
// - Redirect back to register_product.php with a message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/product_db.php');        // used to read productCode for message
require_once('../model/registration_db.php');   // used to register product

// Read posted values safely
$customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
$email       = trim((string) filter_input(INPUT_POST, 'email'));

// Basic validation (must have valid IDs and email for redirect)
if (!$customer_id || !$product_id || $email === '') {
    $error_message = 'Invalid customer or product selection.';
    include('../errors/error.php');
    exit();
}

// Attempt to register the product (returns false if already registered)
$registered = register_product($customer_id, $product_id);

// Load product info so we can show the product code in the message
$product = get_product($product_id);
$product_code = $product ? (string)$product['productCode'] : '';

// Build a friendly message (includes product code when available)
if ($registered) {
    $message = $product_code !== ''
        ? "Product was registered successfully. Product code: $product_code"
        : "Product was registered successfully.";
} else {
    $message = $product_code !== ''
        ? "This product is already registered. Product code: $product_code"
        : "This product is already registered.";
}

// Redirect back to the registration page (email used to re-load customer)
header('Location: register_product.php?email=' . urlencode($email) . '&message=' . urlencode($message));
exit();