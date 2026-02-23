<?php
// customer_manager/index.php
// Purpose: Entry page to search customers by last name + Add Customer button

require_once('../util/require_login.php');
require_login('../'); // must run BEFORE any HTML output

$pageTitle = "Customer Manager";
$basePath  = "../";
include('../includes/header.php');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0">Search Customers</h1>

    <div class="d-flex gap-2">
        <!-- ✅ Project 20-1: Add Customer -->
        <a href="customer_select.php?action=add" class="btn btn-primary">
            Add Customer
        </a>

        <a href="../index.php" class="btn btn-outline-secondary">
            Home
        </a>
    </div>
</div>

<form action="customer_search.php" method="get" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="lastName" class="form-control" placeholder="Enter last name">
    </div>

    <div class="col-md-6 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
            Search
        </button>
    </div>
</form>

<?php include('../includes/footer.php'); ?>