<?php
// This file creates the database connection
// It runs ONCE and is reused everywhere

$dsn = 'mysql:host=localhost;dbname=tech_support;charset=utf8mb4';
$username = 'root';   // XAMPP default
$password = '';       // empty password by default

try {
    // Create PDO connection
    $db = new PDO($dsn, $username, $password);

    // Show errors if something breaks (dev mode)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // If DB connection fails, show error page
    $error_message = 'Database error: ' . $e->getMessage();
    include('../errors/error.php');
    exit();
}