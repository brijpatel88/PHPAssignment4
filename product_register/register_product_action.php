<?php
// product_register/register_product_action.php
// Purpose:
// - Customer must be logged in
// - Register selected product for the logged-in customer
// - Redirect back with a message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../util/require_customer_login.php');
require_customer_login('../');

require_once('../model/database.php');
require_once('../model/product_db.php');        // get_product()
require_once('../model/registration_db.php');   // register_product()

$customer_id = (int)($_SESSION['customer_id'] ?? 0);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);

if ($customer_id <= 0 || !$product_id) {
    $error_message = 'Invalid customer or product selection.';
    include('../errors/error.php');
    exit();
}

$registered = register_product($customer_id, $product_id);

$product = get_product($product_id);
$product_code = $product ? (string)$product['productCode'] : '';

if ($registered) {
    $message = $product_code !== ''
        ? "Product was registered successfully. Product code: $product_code"
        : "Product was registered successfully.";
} else {
    $message = $product_code !== ''
        ? "This product is already registered. Product code: $product_code"
        : "This product is already registered.";
}

header('Location: register_product.php?message=' . urlencode($message));
exit();