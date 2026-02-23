<?php
// incident_display/incident_list.php
// View for Project 20-4

$isAssigned = ($mode === 'assigned');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Display Incidents</h1>
    <div class="text-muted mt-1">
      Viewing: <strong><?php echo $isAssigned ? 'Assigned Incidents' : 'Unassigned Incidents'; ?></strong>
    </div>
  </div>

  <div class="d-flex gap-2">
    <a class="btn <?php echo !$isAssigned ? 'btn-primary' : 'btn-outline-primary'; ?>"
       href="index.php?action=unassigned">Unassigned</a>

    <a class="btn <?php echo $isAssigned ? 'btn-primary' : 'btn-outline-primary'; ?>"
       href="index.php?action=assigned">Assigned</a>

    <a class="btn btn-outline-secondary" href="../index.php">Home</a>
  </div>
</div>

<?php if (count($incidents) === 0): ?>
  <div class="alert alert-info mb-0">
    No incidents found in this view.
  </div>
<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th style="width:110px;">ID</th>
          <th style="width:160px;">Opened</th>
          <th>Customer</th>
          <th>Product</th>

          <?php if ($isAssigned): ?>
            <th style="width:180px;">Technician</th>
            <th style="width:160px;">Date Closed</th>
          <?php endif; ?>

          <th>Title</th>
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

          <?php if ($isAssigned): ?>
            <td>
              <?php
                $techName = trim(($i['techFirstName'] ?? '') . ' ' . ($i['techLastName'] ?? ''));
                echo htmlspecialchars($techName);
              ?>
            </td>

            <td>
              <?php
                if (empty($i['dateClosed'])) {
                    echo '<span class="badge text-bg-success">OPEN</span>';
                } else {
                    $ts2 = strtotime((string)$i['dateClosed']);
                    echo htmlspecialchars($ts2 ? date('n-j-Y', $ts2) : '');
                }
              ?>
            </td>
          <?php endif; ?>

          <td><?php echo htmlspecialchars($i['title']); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php endif; ?>