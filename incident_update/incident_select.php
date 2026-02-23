<?php
// incident_update/incident_select.php
// Purpose: Save selected incident in session, then go to Update Incident page

require_once('../util/require_tech_login.php');
require_tech_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$incidentID = filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);
$techID     = (int)($_SESSION['tech_id'] ?? 0);

if (!$incidentID || $techID <= 0) {
    $error_message = 'Invalid incident selection.';
    include('../errors/error.php');
    exit();
}

// Security: technician can only access their own assigned incidents
if (!incident_belongs_to_technician($incidentID, $techID)) {
    $error_message = 'Access denied. You can only update incidents assigned to you.';
    include('../errors/error.php');
    exit();
}

// Save to session (so Update page doesn’t rely on query string)
$_SESSION['incident_id'] = $incidentID;

header('Location: incident_update.php');
exit();