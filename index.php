<?php
// index.php (ROOT)

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SportsPro Technical Support</title>

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your existing CSS (keep it; Bootstrap will still work) -->
    <link rel="stylesheet" href="css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- Card layout for a cleaner home screen -->
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="mb-2">SportsPro Technical Support</h1>

            <div class="alert alert-success d-inline-block py-2 px-3 mb-4" role="alert">
                Project is running ✅
            </div>

            <!-- Bootstrap list group for menu -->
            <div class="list-group">
                <a class="list-group-item list-group-item-action" href="product_manager">
                    Manage Products
                </a>
                <a class="list-group-item list-group-item-action" href="technician_manager">
                    Manage Technicians
                </a>
                <a class="list-group-item list-group-item-action" href="customer_manager">
                    Manage Customers
                </a>
                <a class="list-group-item list-group-item-action" href="product_register">
                    Register Product
                </a>
                <a class="list-group-item list-group-item-action" href="incident_create">
                    Create Incident
                </a>
            </div>

        </div>
    </div>

</div>

<!-- Bootstrap JS Bundle (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>