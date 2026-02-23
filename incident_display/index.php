<?php
// incident_display/index.php
// Purpose (Project 20-4):
// - Display incidents in two views: Unassigned and Assigned
// - Assigned must show tech name and "OPEN" if not closed

require_once('../util/require_login.php');
require_login('../'); // Admin only

require_once('../model/database.php');
require_once('../model/incident_db.php');

$action = filter_input(INPUT_GET, 'action');
if ($action === null) {
    $action = 'unassigned';
}

switch ($action) {

    case 'unassigned':
        $incidents = get_unassigned_incidents();
        $mode = 'unassigned';
        break;

    case 'assigned':
        $incidents = get_assigned_incidents();
        $mode = 'assigned';
        break;

    default:
        $incidents = get_unassigned_incidents();
        $mode = 'unassigned';
        break;
}

$pageTitle = "Display Incidents";
$basePath  = "../";
include('../includes/header.php');
include('incident_list.php');
include('../includes/footer.php');