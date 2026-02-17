<?php
// technician_manager/add_technician_form.php
// Purpose: Display form to add a technician (POST -> add_technician.php)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Technician</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-4">Add Technician</h1>

            <form action="add_technician.php" method="post">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Add Technician
                    </button>

                    <a href="index.php" class="btn btn-outline-secondary ms-2">
                        View Technician List
                    </a>

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