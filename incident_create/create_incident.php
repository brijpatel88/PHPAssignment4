<?php
// incident_create/create_incident.php
// Purpose:
// 1) Receive email
// 2) Find customer
// 3) Show form to create a new incident

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/product_db.php');

// Get email safely (avoid trim(null))
$email = trim((string) filter_input(INPUT_POST, 'email'));
if ($email === '') {
    $email = trim((string) filter_input(INPUT_GET, 'email'));
}

if ($email === '') {
    $error_message = 'Please enter an email address.';
    include('../errors/error.php');
    exit();
}

// Find customer by email (function from Project 6-4)
$customer = get_customer_by_email($email);
if (!$customer) {
    $error_message = 'No customer found with that email.';
    include('../errors/error.php');
    exit();
}

// Get all products for dropdown
$products = get_products();

// Optional message
$message = trim((string) filter_input(INPUT_GET, 'message'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Incident</title>
</head>
<body>

<h1>Create Incident</h1>

<p>
    Logged in as:
    <strong><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></strong>
    (<?php echo htmlspecialchars($customer['email']); ?>)
</p>

<?php if ($message !== ''): ?>
    <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
<?php endif; ?>

<form action="create_incident_action.php" method="post">
    <!-- Keep IDs for insert -->
    <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">

    <label>Product:</label>
    <select name="productID">
        <?php foreach ($products as $p): ?>
            <option value="<?php echo (int)$p['productID']; ?>">
                <?php echo htmlspecialchars($p['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Title:</label>
    <input type="text" name="title">
    <br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="6" cols="50"></textarea>
    <br><br>

    <button type="submit">Create Incident</button>
</form>

<p><a href="index.php">Logout</a></p>
<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>