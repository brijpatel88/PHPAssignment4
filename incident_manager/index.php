<?php
// incident_manager/index.php
// Purpose: Project 20-2 Assign Incidents (3-step session flow)
// - Step 1: list_unassigned (only open + unassigned)
// - Step 2: choose_tech (select technician with open incident count)
// - Step 3: confirm_assign (confirm + assign from session)

require_once('../util/require_login.php');
require_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');
require_once('../model/technician_db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
}
if ($action === null || $action === '') {
    $action = 'list_unassigned';
}

switch ($action) {

    // --------------------------------------------
    // STEP 1: List ONLY unassigned open incidents
    // --------------------------------------------
    case 'list_unassigned':
        $incidents = get_unassigned_open_incidents(); // from model/incident_db.php
        $message   = trim((string) filter_input(INPUT_GET, 'message'));

        $pageTitle = "Incident Manager";
        $basePath  = "../";
        include('../includes/header.php');
        include('incident_list.php');      // expects $incidents, $message
        include('../includes/footer.php');
        break;

    // --------------------------------------------
    // STEP 1 -> STEP 2: Save incidentID into session
    // --------------------------------------------
    case 'select_incident':
        $incidentID = filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);

        if (!$incidentID) {
            $error_message = 'Invalid incident selection.';
            include('../errors/error.php');
            exit();
        }

        // Store in session (Project 20-2 requirement)
        $_SESSION['assign_incident_id'] = (int)$incidentID;

        header('Location: index.php?action=choose_tech');
        exit();

    // --------------------------------------------
    // STEP 2: Choose technician (with open incident count)
    // --------------------------------------------
    case 'choose_tech':
        $incidentID = (int)($_SESSION['assign_incident_id'] ?? 0);

        if ($incidentID <= 0) {
            header('Location: index.php?action=list_unassigned&message=' . urlencode('Please select an incident first.'));
            exit();
        }

        $incident = get_incident($incidentID);
        if (!$incident) {
            // clean session if incident missing
            unset($_SESSION['assign_incident_id']);
            $error_message = 'Incident not found.';
            include('../errors/error.php');
            exit();
        }

        // Build technician list WITH open incident count (correlated subquery)
        // This matches the assignment requirement style.
        try {
            $query = '
                SELECT
                    t.techID,
                    t.firstName,
                    t.lastName,
                    (
                        SELECT COUNT(*)
                        FROM incidents i
                        WHERE i.techID = t.techID
                          AND i.dateClosed IS NULL
                    ) AS openCount
                FROM technicians t
                ORDER BY t.lastName, t.firstName
            ';
            $stmt = $db->prepare($query);
            $stmt->execute();
            $technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            require_once('../util/db_error.php');
            show_database_error('Unable to load technicians for assignment.', $e);
        }

        $pageTitle = "Assign Technician";
        $basePath  = "../";
        include('../includes/header.php');
        include('incident_assign.php');    // expects $incident, $technicians
        include('../includes/footer.php');
        break;

    // --------------------------------------------
    // STEP 2 -> STEP 3: Save techID into session
    // --------------------------------------------
    case 'select_tech':
        $techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

        if (!$techID) {
            header('Location: index.php?action=choose_tech&message=' . urlencode('Please select a technician.'));
            exit();
        }

        // Save in session (Project 20-2 requirement)
        $_SESSION['assign_tech_id'] = (int)$techID;

        // Also store tech name for the confirm screen (nice UX)
        try {
            $q = 'SELECT firstName, lastName FROM technicians WHERE techID = :techID';
            $s = $db->prepare($q);
            $s->bindValue(':techID', $techID, PDO::PARAM_INT);
            $s->execute();
            $row = $s->fetch(PDO::FETCH_ASSOC);

            $_SESSION['assign_tech_name'] = $row
                ? trim($row['firstName'] . ' ' . $row['lastName'])
                : 'Technician';
        } catch (PDOException $e) {
            require_once('../util/db_error.php');
            show_database_error('Unable to load technician name.', $e);
        }

        header('Location: index.php?action=confirm_assign');
        exit();

    // --------------------------------------------
    // STEP 3: Confirmation page
    // --------------------------------------------
    case 'confirm_assign':
        $incidentID = (int)($_SESSION['assign_incident_id'] ?? 0);
        $techID     = (int)($_SESSION['assign_tech_id'] ?? 0);

        if ($incidentID <= 0) {
            header('Location: index.php?action=list_unassigned&message=' . urlencode('Please select an incident first.'));
            exit();
        }
        if ($techID <= 0) {
            header('Location: index.php?action=choose_tech&message=' . urlencode('Please select a technician first.'));
            exit();
        }

        $incident = get_incident($incidentID);
        if (!$incident) {
            unset($_SESSION['assign_incident_id'], $_SESSION['assign_tech_id'], $_SESSION['assign_tech_name']);
            $error_message = 'Incident not found.';
            include('../errors/error.php');
            exit();
        }

        $techName = (string)($_SESSION['assign_tech_name'] ?? 'Technician');

        $pageTitle = "Confirm Assignment";
        $basePath  = "../";
        include('../includes/header.php');
        include('incident_confirm.php');  // expects $incident, $techName
        include('../includes/footer.php');
        break;

    // --------------------------------------------
    // STEP 3: Assign using IDs stored in session
    // --------------------------------------------
    case 'assign_from_session':
        $incidentID = (int)($_SESSION['assign_incident_id'] ?? 0);
        $techID     = (int)($_SESSION['assign_tech_id'] ?? 0);

        if ($incidentID <= 0 || $techID <= 0) {
            $error_message = 'Assignment session data missing. Please start again.';
            include('../errors/error.php');
            exit();
        }

        assign_incident($incidentID, $techID);

        // Clear session keys used for assignment flow
        unset($_SESSION['assign_incident_id'], $_SESSION['assign_tech_id'], $_SESSION['assign_tech_name']);

        header('Location: index.php?action=list_unassigned&message=' . urlencode('Incident assigned successfully.'));
        exit();

    // --------------------------------------------
    default:
        $error_message = 'Unknown action.';
        include('../errors/error.php');
        exit();
}