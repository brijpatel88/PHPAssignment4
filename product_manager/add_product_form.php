<?php
// product_manager/add_product_form.php
// Purpose: Add Product form (posts to controller)
// Project 10-1: user can enter any valid date format
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>
<body>
<div class="container">

<h1>Add Product</h1>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="add_product">

    <label>Product Code:</label>
    <input type="text" name="code">
    <br><br>

    <label>Name:</label>
    <input type="text" name="name">
    <br><br>

    <label>Version:</label>
    <input type="text" name="version">
    <br><br>

    <label>Release Date:</label>
    <input type="text" name="releaseDate" placeholder="Example: 2026-02-08 or Feb 8 2026">
    <br><br>

    <button type="submit">Add Product</button>
</form>

<p><a href="index.php">View Product List</a> | <a href="../index.php">Home</a></p>

</div>
</body>
</html>