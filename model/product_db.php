<?php
// This file handles PRODUCT database actions only

// Get all products from DB
function get_products(): array
{
    global $db; // use DB connection

    $query = 'SELECT productID, productCode, name, version, releaseDate
              FROM products
              ORDER BY name';

    $statement = $db->prepare($query);
    $statement->execute();

    // Return list of products
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Delete a product by ID
function delete_product(int $product_id): void
{
    global $db;

    $query = 'DELETE FROM products WHERE productID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $product_id);
    $statement->execute();
}

// Purpose: get one product (so we can show productCode in success message)

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

// Add a new product
function add_product(string $code, string $name, string $version, string $release_date): void
{
    global $db;

    $query = 'INSERT INTO products
              (productCode, name, version, releaseDate)
              VALUES (:code, :name, :version, :date)';

    $statement = $db->prepare($query);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':date', $release_date);
    $statement->execute();
}