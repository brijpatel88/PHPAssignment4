<?php
// model/technician_db.php
// Purpose: Database operations for technicians (procedural version)

require_once(__DIR__ . '/../util/db_error.php');

function get_technicians(): array
{
    global $db;

    try {
        $query = 'SELECT techID, firstName, lastName, email, phone
                  FROM technicians
                  ORDER BY lastName';

        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load technicians.', $e);
        return [];
    }
}

/**
 * ✅ Project 20-2: list techs with OPEN incident count (correlated subquery)
 */
function get_technicians_with_open_incident_count(): array
{
    global $db;

    try {
        $query = '
            SELECT
                t.techID,
                t.firstName,
                t.lastName,
                t.email,
                t.phone,
                (
                    SELECT COUNT(*)
                    FROM incidents i
                    WHERE i.techID = t.techID
                      AND i.dateClosed IS NULL
                ) AS openCount
            FROM technicians t
            ORDER BY t.lastName, t.firstName
        ';

        $statement = $db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load technicians with open incident count.', $e);
        return [];
    }
}

function add_technician(string $firstName, string $lastName, string $email, string $phone, string $password): void
{
    global $db;

    try {
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

    } catch (PDOException $e) {
        show_database_error('Unable to add technician.', $e);
    }
}

function delete_technician(int $tech_id): void
{
    global $db;

    try {
        $query = 'DELETE FROM technicians WHERE techID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $tech_id, PDO::PARAM_INT);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to delete technician.', $e);
    }
}

function get_technician_by_email_password(string $email, string $password): array|false
{
    global $db;

    try {
        $query = 'SELECT techID, firstName, lastName, email
                  FROM technicians
                  WHERE email = :email AND password = :password';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to login technician.', $e);
        return false;
    }
}