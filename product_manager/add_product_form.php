<?php
// product_manager/add_product_form.php
// Purpose: Displays form to add a new product
// - Posts back to product_manager/index.php controller
// - Accepts flexible release date formats
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: keep your custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-4">Add Product</h1>

            <!-- Product form -->
            <form action="index.php" method="post">

                <!-- Controller action -->
                <input type="hidden" name="action" value="add_product">

                <!-- Product Code -->
                <div class="mb-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="code" class="form-control">
                </div>

                <!-- Product Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <!-- Version -->
                <div class="mb-3">
                    <label class="form-label">Version</label>
                    <input type="text" name="version" class="form-control">
                </div>

                <!-- Release Date -->
                <div class="mb-4">
                    <label class="form-label">Release Date</label>
                    <input type="text"
                           name="releaseDate"
                           class="form-control"
                           placeholder="Example: 2026-02-08 or Feb 8 2026">
                    <div class="form-text">
                        You may enter any standard date format.
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">
                    Add Product
                </button>

                <!-- Navigation links -->
                <a href="index.php" class="btn btn-outline-secondary ms-2">
                    View Product List
                </a>

                <a href="../index.php" class="btn btn-link ms-2">
                    Home
                </a>

            </form>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>