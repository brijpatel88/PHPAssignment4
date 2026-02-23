<?php
// product_manager/add_product_form.php
// Purpose:
// - Displays form to add a new product
// - Posts back to product_manager/index.php controller
// - Accepts flexible release date formats

$pageTitle = "Add Product";
$basePath  = "../";
include('../includes/header.php');
require_once('../util/require_login.php');
require_login('../');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0">Add Product</h1>

    <!-- Top-right navigation -->
    <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-outline-secondary">
            View Product List
        </a>
        <a href="../index.php" class="btn btn-outline-secondary">
            Home
        </a>
    </div>
</div>

<form action="index.php" method="post" class="mt-3">
    <!-- Controller action -->
    <input type="hidden" name="action" value="add_product">

    <div class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Product Code</label>
            <input type="text" name="code" class="form-control">
        </div>

        <div class="col-md-5">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Version</label>
            <input type="text" name="version" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Release Date</label>
            <input type="text"
                   name="releaseDate"
                   class="form-control"
                   placeholder="Example: 2026-02-08 or Feb 8 2026">
            <div class="form-text">
                You may enter any standard date format.
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                Add Product
            </button>
        </div>

    </div>
</form>

<?php include('../includes/footer.php'); ?>