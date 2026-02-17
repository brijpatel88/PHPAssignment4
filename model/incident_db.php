<?php
// model/incident_db.php
// Purpose: Database operations for incidents (insert new incident, etc.)

function add_incident(
    int $customer_id,
    int $product_id,
    string $title,
    string $description
): void {
    global $db;

    // Insert a new incident
    // techID is NULL initially, dateClosed is NULL initially
    $query = 'INSERT INTO incidents
              (customerID, productID, techID, dateOpened, dateClosed, title, description)
              VALUES
              (:customerID, :productID, NULL, NOW(), NULL, :title, :description)';

    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customer_id, PDO::PARAM_INT);
    $statement->bindValue(':productID', $product_id, PDO::PARAM_INT);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
}