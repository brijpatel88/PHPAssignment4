<?php
// model/database_oo.php
// Purpose: Object-oriented database connection using PDO

require_once(__DIR__ . '/database.php'); // for DB credentials
// We reuse your existing PDO connection from database.php.
// That file should set $db as a PDO object.

// This function returns the existing PDO connection
function get_db(): PDO
{
    global $db;
    return $db;
}