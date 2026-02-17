<?php
// customer_manager/customer_search.php
// Purpose:
// - Receive lastName (GET)
// - Query matching customers
// - Display results table with Select buttons

require_once('../model/database.php');
require_once('../model/customer_db.php');

$lastName = trim((string) filter_input(INPUT_GET, 'lastName'));

if ($lastName === '') {
    $error_message = 'Please enter a last name to search.';
    include('../errors/error.php');
    exit();
}

$customers = get_customers_by_last_name($lastName);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Search Results</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-3">Customer Search Results</h1>

            <div class="mb-3 text-muted">
                Search for last name: <strong><?php echo htmlspecialchars($lastName); ?></strong>
            </div>

            <?php if (count($customers) === 0): ?>
                <div class="alert alert-warning" role="alert">
                    No customers found.
                </div>

                <a href="index.php" class="btn btn-primary">Search Again</a>
                <a href="../index.php" class="btn btn-link ms-2">Home</a>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
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
                                    <!-- Select sends customerID to customer_select.php -->
                                    <form action="customer_select.php" method="get" class="m-0">
                                        <input type="hidden" name="customerID" value="<?php echo (int)$c['customerID']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Select
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <a href="index.php" class="btn btn-outline-secondary">Search Again</a>
                <a href="../index.php" class="btn btn-link ms-2">Home</a>

            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>