<?php
// incident_create/index.php
// Purpose: Entry page for Create Incident (customer must be logged in)

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../util/require_customer_login.php');
require_customer_login('../'); // customer must be logged in

$pageTitle = "Create Incident";
$basePath  = "../";
include('../includes/header.php');

$customerName  = $_SESSION['customer_name']  ?? 'Customer';
$customerEmail = $_SESSION['customer_email'] ?? '';
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="mb-0">Create Incident</h1>
        <div class="text-muted mt-1">
            Logged in as <strong><?php echo htmlspecialchars($customerName); ?></strong>
            <?php if ($customerEmail !== ''): ?>
                (<?php echo htmlspecialchars($customerEmail); ?>)
            <?php endif; ?>
        </div>
    </div>

    <a href="../customer_portal/index.php" class="btn btn-outline-secondary">Back</a>
</div>

<div class="alert alert-info">
    You are logged in. Click Continue to create an incident for your registered products.
</div>

<a class="btn btn-primary" href="create_incident.php">Continue</a>

<?php include('../includes/footer.php'); ?>
