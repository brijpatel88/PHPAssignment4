<?php
// model/country_db.php
// Purpose: Retrieve countries for dropdown lists

require_once(__DIR__ . '/../util/db_error.php');

function get_countries(): array
{
    global $db;

    try {
        $query = 'SELECT countryCode, countryName
                  FROM countries
                  ORDER BY countryName';

        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load country list.', $e);
    }
}