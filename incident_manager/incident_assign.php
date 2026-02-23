<?php
// incident_manager/incident_assign.php
// Purpose: Step 2 (Project 20-2) - Choose technician for selected incident

$customerName = trim(($incident['customerFirstName'] ?? '') . ' ' . ($incident['customerLastName'] ?? ''));
$message = trim((string) filter_input(INPUT_GET, 'message'));
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Assign Technician</h1>
    <div class="text-muted">Step 2 of 3 — choose technician.</div>
  </div>

  <div class="d-flex gap-2">
    <a href="index.php?action=list_unassigned" class="btn btn-outline-secondary">Back</a>
  </div>
</div>

<?php if ($message !== ''): ?>
  <div class="alert alert-warning"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <div class="row g-2">
      <div class="col-md-3"><strong>Incident ID:</strong> <?php echo (int)$incident['incidentID']; ?></div>
      <div class="col-md-4"><strong>Customer:</strong> <?php echo htmlspecialchars($customerName); ?></div>
      <div class="col-md-5"><strong>Product:</strong> <?php echo htmlspecialchars($incident['productName'] ?? ''); ?></div>
      <div class="col-12"><strong>Title:</strong> <?php echo htmlspecialchars($incident['title'] ?? ''); ?></div>
    </div>
  </div>
</div>

<form action="index.php" method="post" class="card shadow-sm">
  <div class="card-body">
    <input type="hidden" name="action" value="select_tech">

    <div class="mb-3">
      <label class="form-label">Technician (Open incident count)</label>
      <select name="techID" class="form-select" required>
        <option value="">Select technician...</option>
        <?php foreach ($technicians as $t): ?>
          <option value="<?php echo (int)$t['techID']; ?>">
            <?php
              $name = trim($t['firstName'] . ' ' . $t['lastName']);
              $count = (int)($t['openCount'] ?? 0);
              echo htmlspecialchars($name . " (Open: $count)");
            ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Next</button>
    <a href="index.php?action=list_unassigned" class="btn btn-outline-secondary ms-2">Cancel</a>
  </div>
</form>