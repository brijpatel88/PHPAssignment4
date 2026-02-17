<?php
// product_register/register_product.php
// Purpose:
// - Receive email (POST from login OR GET from redirect)
// - Load customer by email
// - Show product dropdown and allow registration
// - Show optional success/error message after redirect

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/product_db.php');

// Get email safely (POST first, then GET after redirects)
$email = trim((string) filter_input(INPUT_POST, 'email'));
if ($email === '') {
    $email = trim((string) filter_input(INPUT_GET, 'email'));
}

// Email is required to identify customer
if ($email === '') {
    $error_message = 'Please enter an email address.';
    include('../errors/error.php');
    exit();
}

// Load customer record by email
$customer = get_customer_by_email($email);
if (!$customer) {
    $error_message = 'No customer found with that email.';
    include('../errors/error.php');
    exit();
}

// Load products for dropdown
$products = get_products();

// Optional message from redirect
$message = trim((string) filter_input(INPUT_GET, 'message'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: keep your custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-3">Register Product</h1>

            <!-- Customer summary -->
            <div class="mb-3">
                <span class="text-muted">Logged in as:</span>
                <strong><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></strong>
                <span class="text-muted">(<?php echo htmlspecialchars($customer['email']); ?>)</span>
            </div>

            <!-- Optional message shown after redirects -->
            <?php if ($message !== ''): ?>
                <div class="alert alert-info" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Register Product form -->
            <form action="register_product_action.php" method="post">

                <!-- Hidden values needed to insert + redirect back -->
                <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">

                <!-- Product dropdown -->
                <div class="mb-4">
                    <label class="form-label">Product</label>
                    <select name="productID" class="form-select">
                        <?php foreach ($products as $p): ?>
                            <option value="<?php echo (int)$p['productID']; ?>">
                                <?php echo htmlspecialchars($p['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Buttons -->
                <button type="submit" class="btn btn-primary">
                    Register Product
                </button>

                <a href="index.php" class="btn btn-outline-secondary ms-2">
                    Logout
                </a>

                <a href="../index.php" class="btn btn-link ms-2">
                    Home
                </a>

            </form>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>