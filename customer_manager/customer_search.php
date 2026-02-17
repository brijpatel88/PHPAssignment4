<?php
// customer_manager/customer_search.php
// Purpose: receives lastName, searches DB, shows matching customers

require_once('../model/database.php');
require_once('../model/customer_db.php');

$lastName = trim(filter_input(INPUT_GET, 'lastName'));

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
    <title>Customer Search</title>
</head>
<body>

<h1>Customer Search Results</h1>
<p>Search for last name: <strong><?php echo htmlspecialchars($lastName); ?></strong></p>

<?php if (count($customers) === 0): ?>
    <p>No customers found.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php foreach ($customers as $c): ?>
            <tr>
                <td><?php echo htmlspecialchars($c['firstName']); ?></td>
                <td><?php echo htmlspecialchars($c['lastName']); ?></td>
                <td><?php echo htmlspecialchars($c['email']); ?></td>
                <td>
                    <!-- Select button goes to customer_select.php with customerID -->
                    <form action="customer_select.php" method="get">
                        <input type="hidden" name="customerID"
                               value="<?php echo (int)$c['customerID']; ?>">
                        <button type="submit">Select</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php endif; ?>

<p><a href="index.php">Search Again</a></p>

</body>
</html>