<?php
// customer_manager/customer_update.php
// Purpose: Save customer (ADD or UPDATE) using the same form

require_once('../util/require_login.php');
require_login('../'); // BEFORE output

require_once('../model/database.php');
require_once('../model/customer_db.php');

$action = trim((string) filter_input(INPUT_POST, 'action')) ?: 'edit';

// Read POST values
$customer = [
    'customerID'  => filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT) ?: 0,
    'firstName'   => trim((string) filter_input(INPUT_POST, 'firstName')),
    'lastName'    => trim((string) filter_input(INPUT_POST, 'lastName')),
    'address'     => trim((string) filter_input(INPUT_POST, 'address')),
    'city'        => trim((string) filter_input(INPUT_POST, 'city')),
    'state'       => trim((string) filter_input(INPUT_POST, 'state')),
    'postalCode'  => trim((string) filter_input(INPUT_POST, 'postalCode')),
    'countryCode' => trim((string) filter_input(INPUT_POST, 'countryCode')),
    'phone'       => trim((string) filter_input(INPUT_POST, 'phone')),
    'email'       => trim((string) filter_input(INPUT_POST, 'email')),
    'password'    => trim((string) filter_input(INPUT_POST, 'password')),
];

// Required fields (phone can be optional depending on your teacher, but keep it allowed)
if ($customer['firstName'] === '' ||
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

if ($action === 'add' || (int)$customer['customerID'] === 0) {
    // ✅ Add new customer
    $newID = add_customer($customer);

    // Redirect to view/edit the newly added customer
    header('Location: customer_select.php?customerID=' . (int)$newID);
    exit();
}

// ✅ Update existing customer
update_customer($customer);

// Redirect back to customer page
header('Location: customer_select.php?customerID=' . (int)$customer['customerID']);
exit();