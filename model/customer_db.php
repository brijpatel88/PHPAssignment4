<?php
// model/customer_db.php

require_once(__DIR__ . '/../util/db_error.php');

function get_customers_by_last_name(string $lastName): array
{
    global $db;

    try {
        $query = 'SELECT customerID, firstName, lastName, email
                  FROM customers
                  WHERE lastName = :lastName
                  ORDER BY firstName';

        $statement = $db->prepare($query);
        $statement->bindValue(':lastName', $lastName);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to search customers by last name.', $e);
        return [];
    }
}

function get_customer_by_email(string $email): array|false
{
    global $db;

    try {
        $query = 'SELECT customerID, firstName, lastName, email
                  FROM customers
                  WHERE email = :email';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load customer by email.', $e);
        return false;
    }
}

function get_customer_by_email_password(string $email, string $password): array|false
{
    global $db;

    try {
        $query = 'SELECT customerID, firstName, lastName, email
                  FROM customers
                  WHERE email = :email AND password = :password';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to login customer.', $e);
        return false;
    }
}

function get_customer(int $customerID): array|false
{
    global $db;

    try {
        $query = 'SELECT customerID, firstName, lastName, address, city, state,
                         postalCode, countryCode, phone, email, password
                  FROM customers
                  WHERE customerID = :customerID';

        $statement = $db->prepare($query);
        $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load customer details.', $e);
        return false;
    }
}

function update_customer(array $customer): void
{
    global $db;

    try {
        $query = 'UPDATE customers
                  SET firstName = :firstName,
                      lastName = :lastName,
                      address = :address,
                      city = :city,
                      state = :state,
                      postalCode = :postalCode,
                      countryCode = :countryCode,
                      phone = :phone,
                      email = :email,
                      password = :password
                  WHERE customerID = :customerID';

        $statement = $db->prepare($query);

        $statement->bindValue(':firstName', $customer['firstName']);
        $statement->bindValue(':lastName', $customer['lastName']);
        $statement->bindValue(':address', $customer['address']);
        $statement->bindValue(':city', $customer['city']);
        $statement->bindValue(':state', $customer['state']);
        $statement->bindValue(':postalCode', $customer['postalCode']);
        $statement->bindValue(':countryCode', $customer['countryCode']);
        $statement->bindValue(':phone', $customer['phone']);
        $statement->bindValue(':email', $customer['email']);
        $statement->bindValue(':password', $customer['password']);
        $statement->bindValue(':customerID', $customer['customerID'], PDO::PARAM_INT);

        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to update customer.', $e);
    }
}

/**
 * ✅ Project 20-1: Add a new customer (same form as update)
 * Returns the new customerID.
 */
function add_customer(array $customer): int
{
    global $db;

    try {
        $query = 'INSERT INTO customers
                    (firstName, lastName, address, city, state, postalCode, countryCode, phone, email, password)
                  VALUES
                    (:firstName, :lastName, :address, :city, :state, :postalCode, :countryCode, :phone, :email, :password)';

        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $customer['firstName']);
        $statement->bindValue(':lastName', $customer['lastName']);
        $statement->bindValue(':address', $customer['address']);
        $statement->bindValue(':city', $customer['city']);
        $statement->bindValue(':state', $customer['state']);
        $statement->bindValue(':postalCode', $customer['postalCode']);
        $statement->bindValue(':countryCode', $customer['countryCode']);
        $statement->bindValue(':phone', $customer['phone']);
        $statement->bindValue(':email', $customer['email']);
        $statement->bindValue(':password', $customer['password']);

        $statement->execute();

        return (int)$db->lastInsertId();

    } catch (PDOException $e) {
        show_database_error('Unable to add customer.', $e);
        return 0; // not reached because show_database_error exits, but keeps PHP happy
    }
}