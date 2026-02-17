<?php
// customer_manager/customer_select.php
// Purpose:
// - Load one customer by customerID
// - Display update form (POST -> customer_update.php)
// - Country dropdown loads from countries table

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

$countries = get_countries(); // dropdown options
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View/Update Customer</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-4">View/Update Customer</h1>

            <!-- Update form -->
            <form action="customer_update.php" method="post">

                <!-- Customer ID is required for the update -->
                <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control"
                               value="<?php echo htmlspecialchars($customer['firstName']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control"
                               value="<?php echo htmlspecialchars($customer['lastName']); ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control"
                               value="<?php echo htmlspecialchars($customer['address']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control"
                               value="<?php echo htmlspecialchars($customer['city']); ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control"
                               value="<?php echo htmlspecialchars($customer['state']); ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postalCode" class="form-control"
                               value="<?php echo htmlspecialchars($customer['postalCode']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <select name="countryCode" class="form-select">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo htmlspecialchars($country['countryCode']); ?>"
                                    <?php if ($country['countryCode'] === $customer['countryCode']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($country['countryName']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?php echo htmlspecialchars($customer['phone']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control"
                               value="<?php echo htmlspecialchars($customer['email']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control"
                               value="<?php echo htmlspecialchars($customer['password']); ?>">
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Update Customer
                    </button>

                    <a href="index.php" class="btn btn-outline-secondary ms-2">
                        Back
                    </a>

                    <a href="../index.php" class="btn btn-link ms-2">
                        Home
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>