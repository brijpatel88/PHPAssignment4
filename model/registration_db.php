<?php
// model/registration_db.php
// Purpose: Insert and check registrations

require_once(__DIR__ . '/../util/db_error.php');

function register_product(int $customer_id, int $product_id): bool
{
    global $db;

    try {
        if (is_product_registered($customer_id, $product_id)) {
            return false;
        }

        $query = 'INSERT INTO registrations (customerID, productID, registrationDate)
                  VALUES (:customer_id, :product_id, NOW())';

        $statement = $db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();

        return true;

    } catch (PDOException $e) {
        show_database_error('Unable to register product.', $e);
    }
}

function is_product_registered(int $customer_id, int $product_id): bool
{
    global $db;

    try {
        $query = 'SELECT customerID
                  FROM registrations
                  WHERE customerID = :customer_id AND productID = :product_id';

        $statement = $db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC) !== false;

    } catch (PDOException $e) {
        show_database_error('Unable to check product registration.', $e);
    }
}