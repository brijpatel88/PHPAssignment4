<?php
// model/registration_db.php
// Purpose: functions to INSERT and CHECK registrations in registrations table

function register_product(int $customer_id, int $product_id): bool
{
    global $db;

    // If already registered, return false
    if (is_product_registered($customer_id, $product_id)) {
        return false;
    }

    // Insert registration row with current date/time
    $query = 'INSERT INTO registrations (customerID, productID, registrationDate)
              VALUES (:customer_id, :product_id, NOW())';

    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $statement->execute();

    return true;
}

function is_product_registered(int $customer_id, int $product_id): bool
{
    global $db;

    // Check if a registration already exists
    $query = 'SELECT customerID
              FROM registrations
              WHERE customerID = :customer_id AND productID = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC) !== false;
}