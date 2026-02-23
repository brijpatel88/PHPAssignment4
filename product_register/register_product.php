<?php
// product_register/register_product.php
// Purpose:
// - Customer must be logged in
// - Show product dropdown and allow registration
// - Show optional success/error message after redirect

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../util/require_customer_login.php');
require_customer_login('../');

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/product_db.php');

$pageTitle = "Register Product";
$basePath  = "../";
include('../includes/header.php');

$customerID = (int)($_SESSION['customer_id'] ?? 0);
if ($customerID <= 0) {
    $error_message = 'Customer session missing. Please login again.';
    include('../errors/error.php');
    exit();
}

$customer = get_customer($customerID);
if (!$customer) {
    $error_message = 'Customer not found. Please login again.';
    include('../errors/error.php');
    exit();
}

$products = get_products();
$message  = trim((string) filter_input(INPUT_GET, 'message'));
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="mb-0">Register Product</h1>
    <div class="text-muted mt-1">
      Logged in as:
      <strong><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></strong>
      (<?php echo htmlspecialchars($customer['email']); ?>)
    </div>
  </div>

  <div class="d-flex gap-2">
    <a href="../customer_portal/index.php" class="btn btn-outline-secondary">Back</a>
    <a href="../auth/logout.php" class="btn btn-outline-danger">Logout</a>
  </div>
</div>

<?php if ($message !== ''): ?>
  <div class="alert alert-info" role="alert">
    <?php echo htmlspecialchars($message); ?>
  </div>
<?php endif; ?>

<form action="register_product_action.php" method="post" class="row g-3">

  <div class="col-md-8">
    <label class="form-label">Product</label>
    <select name="productID" class="form-select" required>
      <option value="">Select a product...</option>
      <?php foreach ($products as $p): ?>
        <option value="<?php echo (int)$p['productID']; ?>">
          <?php echo htmlspecialchars($p['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">
      Register Product
    </button>
  </div>

</form>

<?php include('../includes/footer.php'); ?>