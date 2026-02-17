<?php
require_once('../model/database.php');
require_once('../model/product_db.php');

// Get product ID
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if (!$product_id) {
    $error_message = 'Invalid product ID.';
    include('../errors/error.php');
    exit();
}

// Delete product
delete_product($product_id);

// Back to list
header('Location: index.php');
exit();