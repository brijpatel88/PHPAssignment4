<?php
// product_register/register_product.php
// Purpose:
// 1) Receive email from login (POST) OR redirect (GET)
// 2) Find the customer by email
// 3) Show a dropdown of ALL products
// 4) Show a success/error message after registering

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/product_db.php');

// Get email safely (filter_input can return null, so cast to string)
$email = trim((string) filter_input(INPUT_POST, 'email'));
if ($email === '') {
    $email = trim((string) filter_input(INPUT_GET, 'email'));
}

// If email is still empty, stop with an error
if ($email === '') {
    $error_message = 'Please enter an email address.';
    include('../errors/error.php');
    exit();
}

// Find customer by email
$customer = get_customer_by_email($email);
if (!$customer) {
    $error_message = 'No customer found with that email.';
    include('../errors/error.php');
    exit();
}

// Get all products for dropdown
$products = get_products();

// Optional message from redirect (avoid undefined variable warning)
$message = trim((string) filter_input(INPUT_GET, 'message'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register Product</title>
</head>
<body>

<h1>Register Product</h1>

<p>
    Logged in as:
    <strong><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></strong>
    (<?php echo htmlspecialchars($customer['email']); ?>)
</p>

<?php if ($message !== ''): ?>
    <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
<?php endif; ?>

<form action="register_product_action.php" method="post">
    <!-- Needed to insert into registrations -->
    <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">

    <!-- Keep email so action page can redirect back here -->
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">

    <label>Product:</label>
    <select name="productID">
        <?php foreach ($products as $p): ?>
            <option value="<?php echo (int)$p['productID']; ?>">
                <?php echo htmlspecialchars($p['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Register Product</button>
</form>

<p><a href="index.php">Logout</a></p>
<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>