<?php
// product_register/index.php
// Purpose: Customer entry page for product registration (customer must be logged in)

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../util/require_customer_login.php');
require_customer_login('../');

$pageTitle = "Register Product";
$basePath  = "../";
include('../includes/header.php');

$customerName  = $_SESSION['customer_name']  ?? 'Customer';
$customerEmail = $_SESSION['customer_email'] ?? '';
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Register Product</h1>
    <div class="text-muted mt-1">
      Logged in as <strong><?php echo htmlspecialchars($customerName); ?></strong>
      <?php if ($customerEmail !== ''): ?>
        (<?php echo htmlspecialchars($customerEmail); ?>)
      <?php endif; ?>
    </div>
  </div>

  <div class="d-flex gap-2">
    <a href="../customer_portal/index.php" class="btn btn-outline-secondary">Back</a>
    <a href="../auth/logout.php" class="btn btn-outline-danger">Logout</a>
  </div>
</div>

<div class="alert alert-info">
  Click Continue to register a product for your account.
</div>

<a class="btn btn-primary" href="register_product.php">Continue</a>

<?php include('../includes/footer.php'); ?>