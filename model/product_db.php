<?php
// This file handles PRODUCT database actions only

// Get all products from DB (used in Product Manager)
function get_products(): array
{
    global $db;

    $query = 'SELECT productID, productCode, name, version, releaseDate
              FROM products
              ORDER BY name';

    $statement = $db->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Delete a product by ID (used in Product Manager)
function delete_product(int $product_id): void
{
    global $db;

    $query = 'DELETE FROM products WHERE productID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $product_id, PDO::PARAM_INT);
    $statement->execute();
}

// Get one product by ID (used for success messages: productCode, etc.)
function get_product(int $product_id): array|false
{
    global $db;

    $query = 'SELECT productID, productCode, name
              FROM products
              WHERE productID = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Add a new product (used in Product Manager)
function add_product(string $code, string $name, string $version, string $release_date): void
{
    global $db;

    $query = 'INSERT INTO products (productCode, name, version, releaseDate)
              VALUES (:code, :name, :version, :date)';

    $statement = $db->prepare($query);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':date', $release_date);
    $statement->execute();
}


// Get only products that a specific customer has registered
function get_registered_products(int $customer_id): array
{
    global $db;

    // Join registrations + products to get the product details
    $query = 'SELECT p.productID, p.productCode, p.name
              FROM registrations r
              JOIN products p ON r.productID = p.productID
              WHERE r.customerID = :customer_id
              ORDER BY p.name';

    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Check if a specific product is registered to a specific customer
// (Used to protect the incident create action from invalid POST data)
function is_product_registered_to_customer(int $customer_id, int $product_id): bool
{
    global $db;

    $query = 'SELECT 1
              FROM registrations
              WHERE customerID = :customer_id AND productID = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchColumn() !== false;
}