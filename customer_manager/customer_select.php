<?php
// customer_manager/customer_select.php
// Purpose: loads one customer by ID and shows update form

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/country_db.php');

$customerID = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

if (!$customerID) {
    $error_message = 'Invalid customer ID.';
    include('../errors/error.php');
    exit();
}

$customer = get_customer($customerID);

if (!$customer) {
    $error_message = 'Customer not found.';
    include('../errors/error.php');
    exit();
}

$countries = get_countries(); // for dropdown list

?>
<!DOCTYPE html>
<html>
<head>
    <title>View/Update Customer</title>
</head>
<body>

<h1>View/Update Customer</h1>

<!-- Form posts updated data to customer_update.php -->
<form action="customer_update.php" method="post">
    <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">

    First Name:
    <input type="text" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>"><br><br>

    Last Name:
    <input type="text" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>"><br><br>

    Address:
    <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"><br><br>

    City:
    <input type="text" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>"><br><br>

    State:
    <input type="text" name="state" value="<?php echo htmlspecialchars($customer['state']); ?>"><br><br>

    Postal Code:
    <input type="text" name="postalCode" value="<?php echo htmlspecialchars($customer['postalCode']); ?>"><br><br>

    Country Code:
    <select name="countryCode">
        <?php foreach ($countries as $country): ?>
            <option value="<?php echo htmlspecialchars($country['countryCode']); ?>"
                <?php if ($country['countryCode'] === $customer['countryCode']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($country['countryName']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    Phone:
    <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"><br><br>

    Email:
    <input type="text" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>"><br><br>

    Password:
    <input type="text" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>"><br><br>

    <button type="submit">Update Customer</button>
</form>

<p><a href="index.php">Back</a></p>

</body>
</html>