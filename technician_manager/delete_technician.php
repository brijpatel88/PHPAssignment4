<?php
require_once('../model/database.php');
require_once('../model/technician_db.php');

// Get technician ID safely
$tech_id = filter_input(INPUT_POST, 'tech_id', FILTER_VALIDATE_INT);

if (!$tech_id) {
    $error_message = 'Invalid technician ID.';
    include('../errors/error.php');
    exit();
}

// Delete technician
delete_technician($tech_id);

// Return to list
header('Location: index.php');
exit();