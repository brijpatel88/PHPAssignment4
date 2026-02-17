<?php
require_once('../model/database.php');
require_once('../model/product_db.php');

// Get form values
$code = trim($_POST['code']);
$name = trim($_POST['name']);
$version = trim($_POST['version']);
$release_date = trim($_POST['release_date']);

// Simple validation (required fields)
if ($code === '' || $name === '' || $version === '' || $release_date === '') {
    $error_message = 'All fields are required.';
    include('../errors/error.php');
    exit();
}

// Insert product
add_product($code, $name, $version, $release_date);

// Go back to product list
header('Location: index.php');
exit();