<?php
// incident_update/incident_list.php
// Purpose: Select Incident page (shows open incidents assigned to this technician)

require_once('../util/require_tech_login.php');
require_tech_login('../');

require_once('../model/database.php');
require_once('../model/incident_db.php');

$techID   = (int)$_SESSION['tech_id'];
$techName = (string)($_SESSION['tech_name'] ?? 'Technician');

$incidents = get_open_incidents_by_technician($techID);

$pageTitle = "Select Incident";
$basePath  = "../";
include('../includes/header.php');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Select Incident</h1>
    <div class="text-muted">Logged in as: <strong><?php echo htmlspecialchars($techName); ?></strong></div>
  </div>

  <div class="d-flex gap-2">
    <a class="btn btn-outline-secondary" href="<?php echo htmlspecialchars($basePath); ?>auth/logout.php">Logout</a>
  </div>
</div>

<?php if (count($incidents) === 0): ?>
  <div class="alert alert-info">
    There are no open incidents assigned to you.
    <a class="alert-link ms-1" href="incident_list.php">Refresh List of Incidents</a>
  </div>
<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th style="width: 110px;">ID</th>
          <th style="width: 160px;">Opened</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Title</th>
          <th style="width: 140px;">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($incidents as $i): ?>
        <tr>
          <td><?php echo (int)$i['incidentID']; ?></td>
          <td>
            <?php
              $ts = strtotime((string)$i['dateOpened']);
              echo htmlspecialchars($ts ? date('n-j-Y', $ts) : '');
            ?>
          </td>
          <td><?php echo htmlspecialchars($i['customerFirstName'] . ' ' . $i['customerLastName']); ?></td>
          <td><?php echo htmlspecialchars($i['productName']); ?></td>
          <td><?php echo htmlspecialchars($i['title']); ?></td>
          <td>
            <form method="post" action="incident_select.php" class="m-0">
              <input type="hidden" name="incidentID" value="<?php echo (int)$i['incidentID']; ?>">
              <button type="submit" class="btn btn-primary btn-sm">Select</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php endif; ?>

<?php include('../includes/footer.php'); ?>