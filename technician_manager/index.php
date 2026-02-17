<?php
// technician_manager/index.php
// Purpose:
// - Load all technicians from DB
// - Display technician list
// - Provide delete action + link to add technician form

require_once('../model/database.php');
require_once('../model/technician_db.php');

$technicians = get_technicians();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Technician Manager</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-3">Technician List</h1>

            <!-- Top navigation buttons -->
            <div class="mb-3">
                <a href="add_technician_form.php" class="btn btn-primary me-2">
                    Add Technician
                </a>
                <a href="../index.php" class="btn btn-outline-secondary">
                    Home
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($technicians as $tech): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tech['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($tech['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($tech['email']); ?></td>
                            <td><?php echo htmlspecialchars($tech['phone']); ?></td>
                            <td>
                                <!-- Delete form posts to delete_technician.php -->
                                <form action="delete_technician.php" method="post" class="m-0">
                                    <input type="hidden" name="tech_id" value="<?php echo (int)$tech['techID']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>