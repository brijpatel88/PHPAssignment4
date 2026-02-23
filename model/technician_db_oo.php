<?php
// model/technician_db_oo.php
// Purpose: OO data access for technicians table (returns Technician objects)

require_once(__DIR__ . '/database_oo.php');
require_once(__DIR__ . '/technician.php');
require_once(__DIR__ . '/../util/db_error.php');

/**
 * @return Technician[]
 */
function get_technicians_oo(): array
{
    $db = get_db();

    try {
        $query = 'SELECT techID, firstName, lastName, email, phone, password
                  FROM technicians
                  ORDER BY lastName, firstName';

        $statement = $db->prepare($query);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $technicians = [];
        foreach ($rows as $row) {
            $technicians[] = new Technician(
                (int)$row['techID'],
                (string)$row['firstName'],
                (string)$row['lastName'],
                (string)$row['email'],
                (string)$row['phone'],
                (string)$row['password']
            );
        }

        return $technicians;

    } catch (PDOException $e) {
        show_database_error('Unable to load technicians (OOP).', $e);
    }
}

function add_technician_oo(string $firstName, string $lastName, string $email, string $phone, string $password): void
{
    $db = get_db();

    try {
        $query = 'INSERT INTO technicians (firstName, lastName, email, phone, password)
                  VALUES (:firstName, :lastName, :email, :phone, :password)';

        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName',  $lastName);
        $statement->bindValue(':email',     $email);
        $statement->bindValue(':phone',     $phone);
        $statement->bindValue(':password',  $password);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to add technician (OOP).', $e);
    }
}

function delete_technician_oo(int $techID): void
{
    $db = get_db();

    try {
        $query = 'DELETE FROM technicians WHERE techID = :techID';
        $statement = $db->prepare($query);
        $statement->bindValue(':techID', $techID, PDO::PARAM_INT);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to delete technician (OOP).', $e);
    }
}