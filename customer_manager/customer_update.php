<?php
// customer_manager/customer_update.php
// Purpose: receives form data, validates required fields, updates database

require_once('../model/database.php');
require_once('../model/customer_db.php');

// Read POST values
$customer = [
    'customerID'  => filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT),
    'firstName'   => trim(filter_input(INPUT_POST, 'firstName')),
    'lastName'    => trim(filter_input(INPUT_POST, 'lastName')),
    'address'     => trim(filter_input(INPUT_POST, 'address')),
    'city'        => trim(filter_input(INPUT_POST, 'city')),
    'state'       => trim(filter_input(INPUT_POST, 'state')),
    'postalCode'  => trim(filter_input(INPUT_POST, 'postalCode')),
    'countryCode' => trim(filter_input(INPUT_POST, 'countryCode')),
    'phone'       => trim(filter_input(INPUT_POST, 'phone')),
    'email'       => trim(filter_input(INPUT_POST, 'email')),
    'password'    => trim(filter_input(INPUT_POST, 'password')),
];

// Basic validation for required fields (phone optional in later project, but OK for now)
if (!$customer['customerID'] ||
    $customer['firstName'] === '' ||
    $customer['lastName'] === '' ||
    $customer['address'] === '' ||
    $customer['city'] === '' ||
    $customer['state'] === '' ||
    $customer['postalCode'] === '' ||
    $customer['countryCode'] === '' ||
    $customer['email'] === '' ||
    $customer['password'] === '') {

    $error_message = 'Please fill in all required fields.';
    include('../errors/error.php');
    exit();
}

// Update DB
update_customer($customer);

// Redirect back to the customer page to see the updated values
header('Location: customer_select.php?customerID=' . $customer['customerID']);
exit();