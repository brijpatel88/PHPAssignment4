<?php
// incident_manager/incident_confirm.php
// Purpose: Step 3 (Project 20-2) - Confirm assignment and save

$customerName = trim(($incident['customerFirstName'] ?? '') . ' ' . ($incident['customerLastName'] ?? ''));
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Confirm Assignment</h1>
    <div class="text-muted">Step 3 of 3 — confirm and assign.</div>
  </div>

  <div class="d-flex gap-2">
    <a href="index.php?action=choose_tech" class="btn btn-outline-secondary">Back</a>
  </div>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <div class="row g-2">
      <div class="col-md-3"><strong>Incident ID:</strong> <?php echo (int)$incident['incidentID']; ?></div>
      <div class="col-md-4"><strong>Customer:</strong> <?php echo htmlspecialchars($customerName); ?></div>
      <div class="col-md-5"><strong>Product:</strong> <?php echo htmlspecialchars($incident['productName'] ?? ''); ?></div>
      <div class="col-12"><strong>Title:</strong> <?php echo htmlspecialchars($incident['title'] ?? ''); ?></div>
      <div class="col-12 mt-2"><strong>Assign to:</strong> <?php echo htmlspecialchars($techName); ?></div>
    </div>
  </div>
</div>

<form method="post" action="index.php" class="d-flex gap-2">
  <input type="hidden" name="action" value="assign_from_session">
  <button type="submit" class="btn btn-primary">Confirm Assign</button>
  <a href="index.php?action=list_unassigned" class="btn btn-outline-secondary">Cancel</a>
</form>