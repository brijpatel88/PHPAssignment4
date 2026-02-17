<?php
// product_manager/product_list.php
// Purpose: Displays list of products
// - Formats release date (n-j-Y)
// - Allows deleting a product
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your custom CSS (optional but kept for consistency) -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-3">Product List</h1>

            <!-- Navigation buttons -->
            <div class="mb-3">
                <a href="index.php?action=show_add_form" class="btn btn-primary me-2">
                    Add Product
                </a>
                <a href="../index.php" class="btn btn-outline-secondary">
                    Home
                </a>
            </div>

            <!-- Bootstrap table styling -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Version</th>
                            <th>Release Date</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($products as $product): ?>
                        <?php
                        // Convert releaseDate to timestamp
                        $ts = strtotime($product['releaseDate']);

                        // Format as month-day-year without leading zeros
                        $formattedDate = $ts ? date('n-j-Y', $ts) : '';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['version']); ?></td>
                            <td><?php echo htmlspecialchars($formattedDate); ?></td>
                            <td>
                                <!-- Delete form posts back to controller -->
                                <form action="index.php" method="post">
                                    <input type="hidden" name="action" value="delete_product">
                                    <input type="hidden" name="code"
                                           value="<?php echo htmlspecialchars($product['productCode']); ?>">
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