<?php
// model/product_db.php
// Purpose: Database operations for products

require_once(__DIR__ . '/../util/db_error.php');

function get_products(): array
{
    global $db;

    try {
        $query = 'SELECT productID, productCode, name, version, releaseDate
                  FROM products
                  ORDER BY name';

        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load products.', $e);
    }
}

function delete_product(int $product_id): void
{
    global $db;

    try {
        $query = 'DELETE FROM products WHERE productID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $product_id, PDO::PARAM_INT);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to delete product.', $e);
    }
}

function get_product(int $product_id): array|false
{
    global $db;

    try {
        $query = 'SELECT productID, productCode, name
                  FROM products
                  WHERE productID = :product_id';

        $statement = $db->prepare($query);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load product details.', $e);
    }
}

function add_product(string $code, string $name, string $version, string $release_date): void
{
    global $db;

    try {
        $query = 'INSERT INTO products (productCode, name, version, releaseDate)
                  VALUES (:code, :name, :version, :date)';

        $statement = $db->prepare($query);
        $statement->bindValue(':code', $code);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':version', $version);
        $statement->bindValue(':date', $release_date);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to add product.', $e);
    }
}

function get_registered_products(int $customer_id): array
{
    global $db;

    try {
        $query = 'SELECT p.productID, p.productCode, p.name
                  FROM registrations r
                  JOIN products p ON r.productID = p.productID
                  WHERE r.customerID = :customer_id
                  ORDER BY p.name';

        $statement = $db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load registered products for this customer.', $e);
    }
}

function is_product_registered_to_customer(int $customer_id, int $product_id): bool
{
    global $db;

    try {
        $query = 'SELECT 1
                  FROM registrations
                  WHERE customerID = :customer_id AND productID = :product_id';

        $statement = $db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn() !== false;

    } catch (PDOException $e) {
        show_database_error('Unable to check product registration.', $e);
    }
}