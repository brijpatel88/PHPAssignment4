<?php
// errors/error.php
// Purpose: Shared error page used across the project.
// It displays the $error_message set by the calling page.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Error</title>

    <!-- Bootstrap CSS (CDN) for clean styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: keep your existing CSS if you want consistent fonts/colors -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="text-danger mb-3">Error</h1>

            <!-- Error message passed from the page that included this file -->
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message ?? 'An unknown error occurred.'); ?>
            </div>

            <!-- Navigation back to home -->
            <a class="btn btn-primary" href="../index.php">Home</a>

        </div>
    </div>

</div>

<!-- Bootstrap JS Bundle (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>