<?php
// product_register/index.php
// Purpose: Customer enters email to start product registration.
// This posts the email to register_product.php.

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register Product - Customer Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: keep custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="mb-4">Register Product - Customer Login</h1>

            <!-- Login form -->
            <form action="register_product.php" method="post">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text"
                           name="email"
                           class="form-control"
                           placeholder="Enter customer email">
                </div>

                <button type="submit" class="btn btn-primary">
                    Login
                </button>

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