<?php
// product_manager/product_list.php
// Purpose: View for Product List page
// Project 10-1: display release date as mm-dd-yyyy with no leading zeros and no time
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>
<body>
<div class="container">

<h1>Product List</h1>

<p><a href="index.php?action=show_add_form">Add Product</a> | <a href="../index.php">Home</a></p>

<table>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Version</th>
        <th>Release Date</th>
        <th>Action</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <?php
        // releaseDate might be stored as DATE (Y-m-d) or DATETIME.
        // We convert to a timestamp safely and format as n-j-Y (no leading zeros).
        $ts = strtotime($product['releaseDate']);
        $formattedDate = $ts ? date('n-j-Y', $ts) : '';
        ?>
        <tr>
            <td><?php echo htmlspecialchars($product['productCode']); ?></td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['version']); ?></td>
            <td><?php echo htmlspecialchars($formattedDate); ?></td>
            <td>
                <form action="index.php" method="post" style="margin:0;">
                    <input type="hidden" name="action" value="delete_product">
                    <input type="hidden" name="code" value="<?php echo htmlspecialchars($product['productCode']); ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</div>
</body>
</html>