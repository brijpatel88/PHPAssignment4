<?php
// Load database connection
require_once('../model/database.php');

// Load technician database functions
require_once('../model/technician_db.php');

// Get all technicians
$technicians = get_technicians();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css?v=1">
    <title>Technician Manager</title>
</head>
<body>

<h1>Technician List</h1>

<table border="1">
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>

    <?php foreach ($technicians as $tech): ?>
        <tr>
            <td><?php echo $tech['firstName']; ?></td>
            <td><?php echo $tech['lastName']; ?></td>
            <td><?php echo $tech['email']; ?></td>
            <td><?php echo $tech['phone']; ?></td>
            <td>
                <!-- Delete form -->
                <form action="delete_technician.php" method="post">
                    <input type="hidden" name="tech_id"
                           value="<?php echo $tech['techID']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<p><a href="add_technician_form.php">Add Technician</a></p>
<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>