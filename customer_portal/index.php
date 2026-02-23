<?php
// customer_portal/index.php
// Purpose: Customer Dashboard (after customer login)

require_once('../util/require_customer_login.php');
require_customer_login('../');

$pageTitle = "Customer Portal";
$basePath  = "../";
include('../includes/header.php');

// Optional display info
$customerName  = $_SESSION['customer_name']  ?? 'Customer';
$customerEmail = $_SESSION['customer_email'] ?? '';
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Customer Portal</h1>
    <div class="text-muted mt-1">
      Logged in as <strong><?php echo htmlspecialchars($customerName); ?></strong>
      <?php if ($customerEmail !== ''): ?>
        (<?php echo htmlspecialchars($customerEmail); ?>)
      <?php endif; ?>
    </div>
  </div>

  <div class="d-flex gap-2">
    <!-- ✅ Real logout (destroys session) -->
    <a class="btn btn-outline-danger" href="../auth/logout.php">Logout</a>

    <!-- Optional: go back to portal (does NOT logout) -->
    <a class="btn btn-outline-secondary" href="../auth/portal.php">Back to Portal</a>
  </div>
</div>

<!-- Cleaner “welcome” banner -->
<div class="p-4 rounded-4 border bg-white mb-3">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
      <h2 class="h5 mb-1">Welcome, <?php echo htmlspecialchars($customerName); ?> 👋</h2>
      <div class="text-muted">
        Choose what you want to do next (Register Product or Create Incident).
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12 col-md-6">
    <div class="border rounded-4 p-4 bg-white h-100 shadow-sm">
      <h5 class="mb-2">Register Product</h5>
      <p class="text-muted mb-3">Register a product for your account.</p>
      <a class="btn btn-primary" href="../product_register/index.php">Continue</a>
    </div>
  </div>

  <div class="col-12 col-md-6">
    <div class="border rounded-4 p-4 bg-white h-100 shadow-sm">
      <h5 class="mb-2">Create Incident</h5>
      <p class="text-muted mb-3">Create an incident for a registered product.</p>
      <a class="btn btn-primary" href="../incident_create/index.php">Continue</a>
    </div>
  </div>
</div>

<?php include('../includes/footer.php'); ?>