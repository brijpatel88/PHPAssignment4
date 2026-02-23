<?php
// technician_manager/delete_technician.php
// Purpose:
// - Require admin login
// - Delete technician using OOP DB layer (Project 14-1)

require_once('../util/require_login.php');
require_login('../');

require_once('../model/technician_db_oo.php');

// Validate tech ID
$techID = filter_input(INPUT_POST, 'tech_id', FILTER_VALIDATE_INT);

if (!$techID) {
    $error_message = 'Invalid technician ID.';
    include('../errors/error.php');
    exit();
}

// Delete technician
delete_technician_oo($techID);

// Redirect back to list
header('Location: index.php');
exit();