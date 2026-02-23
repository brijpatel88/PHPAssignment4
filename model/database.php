<?php
// model/database.php
// Purpose: Create the PDO database connection (shared)

require_once(__DIR__ . '/../util/db_error.php');

$dsn = 'mysql:host=localhost;dbname=tech_support;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Use the central error handler (Project 19-1 requirement)
    show_database_error('Unable to connect to the database.', $e);
}