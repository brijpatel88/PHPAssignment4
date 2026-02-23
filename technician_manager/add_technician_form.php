<?php
// technician_manager/add_technician_form.php
// Purpose:
// - Display form to add a technician (POST -> add_technician.php)

$pageTitle = "Add Technician";
$basePath  = "../";
include('../includes/header.php');
require_once('../util/require_login.php');
require_login('../');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0">Add Technician</h1>

    <!-- Top navigation -->
    <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-outline-secondary">
            View Technician List
        </a>
        <a href="../index.php" class="btn btn-outline-secondary">
            Home
        </a>
    </div>
</div>

<form action="add_technician.php" method="post" class="mt-3">
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" name="firstName" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastName" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="text" name="password" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                Add Technician
            </button>

            <a href="index.php" class="btn btn-outline-secondary ms-2">
                Cancel
            </a>
        </div>

    </div>
</form>

<?php include('../includes/footer.php'); ?>