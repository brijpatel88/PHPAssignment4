<?php
// product_manager/product_list.php
// Purpose:
// - Displays list of products
// - Formats release date (n-j-Y)
// - Allows deleting a product

$pageTitle = "Product List";
$basePath  = "../";
include('../includes/header.php');
require_once('../util/require_login.php');
require_login('../');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="mb-0">Product List</h1>

    <!-- Top-right actions -->
    <div class="d-flex gap-2">
        <a href="index.php?action=show_add_form" class="btn btn-primary">
            Add Product
        </a>
        <a href="../index.php" class="btn btn-outline-secondary">
            Home
        </a>
    </div>
</div>

<!-- Products table -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
        <tr>
            <th style="width: 140px;">Code</th>
            <th>Name</th>
            <th style="width: 120px;">Version</th>
            <th style="width: 160px;">Release Date</th>
            <th style="width: 120px;">Action</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($products as $product): ?>
            <?php
            // Convert releaseDate to timestamp, then format as n-j-Y (no leading zeros)
            $ts = strtotime($product['releaseDate']);
            $formattedDate = $ts ? date('n-j-Y', $ts) : '';
            ?>
            <tr>
                <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['version']); ?></td>
                <td><?php echo htmlspecialchars($formattedDate); ?></td>
                <td>
                    <!-- Delete form posts back to controller -->
                    <form action="index.php" method="post" class="m-0">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="code" value="<?php echo htmlspecialchars($product['productCode']); ?>">
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

<?php include('../includes/footer.php'); ?>