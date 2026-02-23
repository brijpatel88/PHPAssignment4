<?php
// incident_update/incident_update.php
// Purpose:
// - Show Update Incident form for the selected incident (from session)
// - Allow technician to update description + optionally set dateClosed

require_once('../util/require_tech_login.php');
require_tech_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$techID   = (int)($_SESSION['tech_id'] ?? 0);
$techName = (string)($_SESSION['tech_name'] ?? 'Technician');

$incidentID = (int)($_SESSION['incident_id'] ?? 0);
$success    = (int)filter_input(INPUT_GET, 'success', FILTER_VALIDATE_INT);

// If no incident selected, go back to list
if ($incidentID <= 0) {
    header('Location: incident_list.php');
    exit();
}

// Security check
if (!incident_belongs_to_technician($incidentID, $techID)) {
    $error_message = 'Access denied. You can only update incidents assigned to you.';
    include('../errors/error.php');
    exit();
}

// Handle update submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim((string)filter_input(INPUT_POST, 'description'));

    // optional: HTML date input gives YYYY-MM-DD
    $dateClosedInput = trim((string)filter_input(INPUT_POST, 'dateClosed'));
    $dateClosed = ($dateClosedInput === '') ? null : $dateClosedInput;

    if ($description === '') {
        $error_message = 'Description is required.';
        include('../errors/error.php');
        exit();
    }

    // Update (description + optional dateClosed)
    update_incident_description_and_close_date($incidentID, $techID, $description, $dateClosed);

    // If they closed it, it will disappear from open list automatically
    // Clear selected incident to prevent accidental resubmits
    unset($_SESSION['incident_id']);

    header('Location: incident_update.php?success=1');
    exit();
}

// Load incident details for form display
$incident = get_incident($incidentID);
if (!$incident) {
    $error_message = 'Incident not found.';
    include('../errors/error.php');
    exit();
}

$pageTitle = "Update Incident";
$basePath  = "../";
include('../includes/header.php');

// Format dateClosed (if present) for HTML date input (YYYY-MM-DD)
$dateClosedValue = '';
if (!empty($incident['dateClosed'])) {
    $ts = strtotime((string)$incident['dateClosed']);
    if ($ts) {
        $dateClosedValue = date('Y-m-d', $ts);
    }
}

$openedValue = '';
if (!empty($incident['dateOpened'])) {
    $ts = strtotime((string)$incident['dateOpened']);
    if ($ts) {
        $openedValue = date('n-j-Y', $ts);
    }
}
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Update Incident</h1>
    <div class="text-muted">Logged in as: <strong><?php echo htmlspecialchars($techName); ?></strong></div>
  </div>

  <div class="d-flex gap-2">
    <a class="btn btn-outline-secondary" href="incident_list.php">Select Another Incident</a>
    <a class="btn btn-outline-secondary" href="<?php echo htmlspecialchars($basePath); ?>auth/logout.php">Logout</a>
  </div>
</div>

<?php if ($success === 1): ?>
  <div class="alert alert-success">
    Incident updated successfully.
    <a class="alert-link ms-1" href="incident_list.php">Select Another Incident</a>
  </div>

  <?php
    // Also show the “no open incidents” message style if needed (like spec)
    $open = get_open_incidents_by_technician($techID);
    if (count($open) === 0):
  ?>
    <div class="alert alert-info">
      There are no open incidents assigned to you.
      <a class="alert-link ms-1" href="incident_list.php">Refresh List of Incidents</a>
    </div>
  <?php endif; ?>

<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body">

    <div class="mb-3 text-muted">
      <div><strong>Incident ID:</strong> <?php echo (int)$incident['incidentID']; ?></div>
      <div><strong>Product:</strong> <?php echo htmlspecialchars($incident['productName'] ?? ''); ?></div>
      <div><strong>Date Opened:</strong> <?php echo htmlspecialchars($openedValue); ?></div>
      <div><strong>Title:</strong> <?php echo htmlspecialchars($incident['title'] ?? ''); ?></div>
    </div>

    <form method="post" action="incident_update.php" class="row g-3" style="max-width: 760px;">

      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="5" required><?php
          echo htmlspecialchars((string)($incident['description'] ?? ''));
        ?></textarea>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Date Closed (optional)</label>
        <input type="date" name="dateClosed" class="form-control" value="<?php echo htmlspecialchars($dateClosedValue); ?>">
        <div class="form-text">Leave blank to keep the incident open.</div>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">Update Incident</button>
        <a href="incident_list.php" class="btn btn-outline-secondary ms-2">Cancel</a>
      </div>

    </form>

  </div>
</div>

<?php include('../includes/footer.php'); ?>