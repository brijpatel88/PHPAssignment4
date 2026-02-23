<?php
// technician_manager/index.php
// Purpose:
// - Protect page with admin session
// - Load technicians using OOP (Technician objects)
// - Display Name (First + Last in one column)
// - Provide delete action + link to add technician form

require_once('../util/require_login.php');
require_login('../');

require_once('../model/technician_db_oo.php'); // OOP technician DB layer (Project 14-1)

// Fetch Technician objects
$technicians = get_technicians_oo();

// Shared layout variables (used by includes/header.php)
$pageTitle = "Technician Manager";
$basePath  = "../";
include('../includes/header.php');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0">Technician List</h1>

    <div class="d-flex gap-2">
        <a href="add_technician_form.php" class="btn btn-primary">Add Technician</a>
        <a href="../index.php" class="btn btn-outline-secondary">Home</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
        <tr>
            <th style="width: 220px;">Name</th>
            <th>Email</th>
            <th style="width: 160px;">Phone</th>
            <th style="width: 120px;">Action</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($technicians as $tech): ?>
            <tr>
                <td><?php echo htmlspecialchars($tech->getName()); ?></td>
                <td><?php echo htmlspecialchars($tech->getEmail()); ?></td>
                <td><?php echo htmlspecialchars($tech->getPhone()); ?></td>
                <td>
                    <form action="delete_technician.php" method="post" class="m-0">
                        <input type="hidden" name="tech_id" value="<?php echo (int)$tech->getTechID(); ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>