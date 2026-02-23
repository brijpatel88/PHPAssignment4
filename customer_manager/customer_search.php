<?php
// customer_manager/customer_search.php

require_once('../util/require_login.php');
require_login('../'); // BEFORE output

require_once('../model/database.php');
require_once('../model/customer_db.php');

$pageTitle = "Customer Search Results";
$basePath  = "../";
include('../includes/header.php');

$lastName = trim((string) filter_input(INPUT_GET, 'lastName'));

if ($lastName === '') {
    $error_message = 'Please enter a last name to search.';
    include('../errors/error.php');
    exit();
}

$customers = get_customers_by_last_name($lastName);
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="mb-0">Customer Search Results</h1>
        <div class="text-muted mt-1">
            Search for last name: <strong><?php echo htmlspecialchars($lastName); ?></strong>
        </div>
    </div>

    <div class="d-flex gap-2">
        <!-- ✅ Project 20-1: Add Customer -->
        <a href="customer_select.php?action=add" class="btn btn-primary">
            Add Customer
        </a>

        <a href="index.php" class="btn btn-outline-secondary">Search Again</a>
        <a href="../index.php" class="btn btn-outline-secondary">Home</a>
    </div>
</div>

<?php if (count($customers) === 0): ?>
    <div class="alert alert-warning mb-0" role="alert">
        No customers found.
    </div>
<?php else: ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
            <tr>
                <th style="width: 180px;">First Name</th>
                <th style="width: 180px;">Last Name</th>
                <th>Email</th>
                <th style="width: 120px;">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($c['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                    <td>
                        <form action="customer_select.php" method="get" class="m-0">
                            <input type="hidden" name="customerID" value="<?php echo (int)$c['customerID']; ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Select</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<?php include('../includes/footer.php'); ?>