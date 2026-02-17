<?php
// model/country_db.php
// Purpose: Retrieve countries from the database
// Used for dropdown lists (Assignment 3 – Step 7-1)

function get_countries(): array
{
    global $db;

    // Select country code and name for dropdown
    $query = 'SELECT countryCode, countryName
              FROM countries
              ORDER BY countryName';

    $statement = $db->prepare($query);
    $statement->execute();

    // Returns array like:
    // [
    //   ['countryCode' => 'CA', 'countryName' => 'Canada'],
    //   ['countryCode' => 'US', 'countryName' => 'United States']
    // ]
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}