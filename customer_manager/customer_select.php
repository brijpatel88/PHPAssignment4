<?php
// customer_manager/customer_select.php
// Purpose:
// - action=add  -> show empty customer form (Add Customer)
// - customerID  -> load customer and show same form (Update Customer)

require_once('../util/require_login.php');
require_login('../'); // BEFORE output

require_once('../model/database.php');
require_once('../model/customer_db.php');
require_once('../model/country_db.php');

$pageTitle = "Customer";
$basePath  = "../";
include('../includes/header.php');

$action = trim((string) filter_input(INPUT_GET, 'action')) ?: 'edit';
$customerID = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

// Load countries for dropdown (used in BOTH modes)
$countries = get_countries();
if (!is_array($countries)) { $countries = []; }

// ADD MODE: create empty customer defaults
if ($action === 'add') {
    $pageTitle = "Add Customer";

    $customer = [
        'customerID'  => 0,
        'firstName'   => '',
        'lastName'    => '',
        'address'     => '',
        'city'        => '',
        'state'       => '',
        'postalCode'  => '',
        'countryCode' => (count($countries) ? $countries[0]['countryCode'] : ''),
        'phone'       => '',
        'email'       => '',
        'password'    => ''
    ];
} else {
    // EDIT MODE: must have customerID
    if (!$customerID) {
        $error_message = 'Invalid customer ID.';
        include('../errors/error.php');
        exit();
    }

    $pageTitle = "View/Update Customer";

    $customer = get_customer($customerID);
    if (!$customer) {
        $error_message = 'Customer not found.';
        include('../errors/error.php');
        exit();
    }
}
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0"><?php echo ($action === 'add') ? 'Add Customer' : 'View/Update Customer'; ?></h1>

    <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-outline-secondary">Back</a>
        <a href="../index.php" class="btn btn-outline-secondary">Home</a>
    </div>
</div>

<form action="customer_update.php" method="post">
    <!-- Tells save handler whether to add or update -->
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">

    <!-- For update: real ID. For add: 0 -->
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
                    <?php
                      $code = (string)$country['countryCode'];
                      $selected = ($code === (string)$customer['countryCode']) ? 'selected' : '';
                    ?>
                    <option value="<?php echo htmlspecialchars($code); ?>" <?php echo $selected; ?>>
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
            <?php echo ($action === 'add') ? 'Add Customer' : 'Update Customer'; ?>
        </button>
    </div>

</form>

<?php include('../includes/footer.php'); ?>