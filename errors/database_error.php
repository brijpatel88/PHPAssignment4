<?php
// errors/database_error.php
// Purpose: Show a friendly database error screen when a PDO operation fails.
// Usage: set $error_message and (optional) $exception_message then include this file.

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional custom CSS -->
    <link rel="stylesheet" href="../css/main.css?v=1">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h4 text-danger mb-3">Database Error</h1>

            <p class="mb-3">
                <?php echo htmlspecialchars($error_message ?? 'A database error occurred.'); ?>
            </p>

            <?php if (!empty($exception_message)): ?>
                <!-- Helpful for debugging while developing -->
                <div class="alert alert-secondary small mb-3">
                    <strong>Details:</strong><br>
                    <?php echo nl2br(htmlspecialchars($exception_message)); ?>
                </div>
            <?php endif; ?>

            <a href="../index.php" class="btn btn-primary">Home</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>