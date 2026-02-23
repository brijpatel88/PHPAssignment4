<?php
// incident_manager/incident_list.php
// Purpose: Project 20-2 - Show ONLY unassigned open incidents

// Variables expected from controller:
// $incidents, $message
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Unassigned Incidents</h1>
    <div class="text-muted">Only open incidents with no technician assigned.</div>
  </div>

  <div class="d-flex gap-2">
    <a href="../index.php" class="btn btn-outline-secondary">Home</a>
  </div>
</div>

<?php if (!empty($message)): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if (count($incidents) === 0): ?>
  <div class="alert alert-info mb-0">No unassigned incidents found.</div>
<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th style="width:110px;">ID</th>
          <th style="width:160px;">Opened</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Title</th>
          <th style="width:160px;">Action</th>
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
            <form method="post" action="index.php" class="m-0">
              <input type="hidden" name="action" value="select_incident">
              <input type="hidden" name="incidentID" value="<?php echo (int)$i['incidentID']; ?>">
              <button type="submit" class="btn btn-primary btn-sm">Assign</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php endif; ?>