<?php
// This file contains ALL database operations related to technicians

// Get all technicians from the database
function get_technicians(): array
{
    global $db; // use the database connection from database.php

    $query = 'SELECT techID, firstName, lastName, email, phone
              FROM technicians
              ORDER BY lastName';

    $statement = $db->prepare($query);
    $statement->execute();

    // Return all technicians as an array
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new technician
function add_technician(
    string $firstName,
    string $lastName,
    string $email,
    string $phone,
    string $password
): void {
    global $db;

    $query = 'INSERT INTO technicians
              (firstName, lastName, email, phone, password)
              VALUES (:fn, :ln, :email, :phone, :pwd)';

    $statement = $db->prepare($query);
    $statement->bindValue(':fn', $firstName);
    $statement->bindValue(':ln', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':pwd', $password);
    $statement->execute();
}

// Delete a technician by ID
function delete_technician(int $tech_id): void
{
    global $db;

    $query = 'DELETE FROM technicians WHERE techID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $tech_id);
    $statement->execute();
}