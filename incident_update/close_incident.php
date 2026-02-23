<?php
// incident_update/close_incident.php
// Purpose: Close an incident (technician can only close their own incidents)

require_once('../util/require_tech_login.php');
require_tech_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');

$incidentID = filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);
$techID     = (int)($_SESSION['tech_id'] ?? 0);

if (!$incidentID || $techID <= 0) {
    $error_message = 'Invalid incident close request.';
    include('../errors/error.php');
    exit();
}

// Security: technician can only close incidents assigned to them
if (!incident_belongs_to_technician($incidentID, $techID)) {
    $error_message = 'Access denied. You can only close incidents assigned to you.';
    include('../errors/error.php');
    exit();
}

// Close it
close_incident($incidentID);

// Redirect back to list (optional message)
header('Location: incident_list.php?message=' . urlencode('Incident closed successfully.'));
exit();