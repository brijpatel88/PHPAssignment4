<?php
// product_register/register_product_action.php
// Purpose: Register the selected product and redirect back with a message

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/product_db.php');
require_once('../model/registration_db.php');

$customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$product_id  = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
$email       = trim((string) filter_input(INPUT_POST, 'email'));

if (!$customer_id || !$product_id || $email === '') {
    $error_message = 'Invalid customer or product selection.';
    include('../errors/error.php');
    exit();
}

$registered = register_product($customer_id, $product_id);

$product = get_product($product_id);
$product_code = $product ? $product['productCode'] : '';

$message = $registered
    ? "Product was registered successfully. Product code: $product_code"
    : "This product is already registered. Product code: $product_code";

header('Location: register_product.php?email=' . urlencode($email) . '&message=' . urlencode($message));
exit();