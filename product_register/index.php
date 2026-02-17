<?php
// product_register/index.php
// Purpose: Customer "login" page for Project 6-4 (enter email to continue)

// Show errors while we build (remove later if you want)
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css?v=1">
    <title>Customer Login</title>
</head>
<body>

<h1>Customer Login</h1>

<!-- Customer enters email to start product registration -->
<form action="register_product.php" method="post">
    <label>Email:</label>
    <input type="text" name="email">
    <button type="submit">Login</button>
</form>

<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>