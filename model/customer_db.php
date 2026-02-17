<?php
// model/customer_db.php
// Purpose: All database operations for the customers table (no HTML)

function get_customers_by_last_name(string $lastName): array
{
    global $db;

    // Search customers by last name (exact match)
    $query = 'SELECT customerID, firstName, lastName, email
              FROM customers
              WHERE lastName = :lastName
              ORDER BY firstName';

    $statement = $db->prepare($query);
    $statement->bindValue(':lastName', $lastName);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_customer_by_email(string $email): array|false
{
    global $db;

    $query = 'SELECT customerID, firstName, lastName, email
              FROM customers
              WHERE email = :email';

    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();

    // Returns one row OR false if not found
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Purpose: find a customer using email (used for customer login in Project 6-4)
function get_customer(int $customerID): array|false
{
    global $db;

    // Get one customer row by customerID
    $query = 'SELECT customerID, firstName, lastName, address, city, state,
                     postalCode, countryCode, phone, email, password
              FROM customers
              WHERE customerID = :customerID';

    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function update_customer(array $customer): void
{
    global $db;

    // Update customer with all fields
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

    // Bind values
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
}