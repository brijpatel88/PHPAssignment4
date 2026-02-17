<?php
// incident_create/create_incident.php
// Purpose:
// - Receive customer email (login-style)
// - Load customer by email
// - Show incident creation form (product dropdown uses registered products)

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/product_db.php');

// Get email safely (from POST on login OR GET after redirect)
$email = trim((string) filter_input(INPUT_POST, 'email'));
if ($email === '') {
    $email = trim((string) filter_input(INPUT_GET, 'email'));
}

// Email is required to identify the customer
if ($email === '') {
    $error_message = 'Please enter an email address.';
    include('../errors/error.php');
    exit();
}

// Load customer record from database
$customer = get_customer_by_email($email);
if (!$customer) {
    $error_message = 'No customer found with that email.';
    include('../errors/error.php');
    exit();
}

// Load products registered by this customer (for dropdown)
$products = get_registered_products((int)$customer['customerID']);

// Optional message shown after redirects (success or validation)
$message = trim((string) filter_input(INPUT_GET, 'message'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Incident</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: keep your custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-3">Create Incident</h1>

            <!-- Customer summary -->
            <div class="mb-3">
                <span class="text-muted">Logged in as:</span>
                <strong><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></strong>
                <span class="text-muted">(<?php echo htmlspecialchars($customer['email']); ?>)</span>
            </div>

            <!-- Optional status message -->
            <?php if ($message !== ''): ?>
                <div class="alert alert-info" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (count($products) === 0): ?>
                <!-- If no registered products, show guidance instead of form -->
                <div class="alert alert-warning" role="alert">
                    <strong>No registered products found for this customer.</strong><br>
                    Please register a product first, then come back to create an incident.
                </div>

                <a href="../product_register/index.php" class="btn btn-primary me-2">
                    Go to Register Product
                </a>
                <a href="index.php" class="btn btn-outline-secondary me-2">
                    Back
                </a>
                <a href="../index.php" class="btn btn-link">
                    Home
                </a>

            <?php else: ?>

                <!-- Incident creation form -->
                <form action="create_incident_action.php" method="post">

                    <!-- Hidden fields needed for insert + redirect back -->
                    <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">

                    <!-- Product dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="productID" class="form-select">
                            <?php foreach ($products as $p): ?>
                                <option value="<?php echo (int)$p['productID']; ?>">
                                    <?php echo htmlspecialchars($p['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="6" class="form-control"></textarea>
                    </div>

                    <!-- Submit + navigation -->
                    <button type="submit" class="btn btn-primary">
                        Create Incident
                    </button>

                    <a href="index.php" class="btn btn-outline-secondary ms-2">
                        Logout
                    </a>

                    <a href="../index.php" class="btn btn-link ms-2">
                        Home
                    </a>
                </form>

            <?php endif; ?>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>