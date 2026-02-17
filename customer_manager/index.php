<?php
// customer_manager/index.php
// Purpose: Entry page to search customers by last name (GET -> customer_search.php)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Manager</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="mb-4">Search Customers</h1>

            <!-- Search form -->
            <form action="customer_search.php" method="get" class="row g-2 align-items-end">
                <div class="col-sm-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastName" class="form-control" placeholder="Enter last name">
                </div>

                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                    <a href="../index.php" class="btn btn-link ms-2">
                        Home
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>