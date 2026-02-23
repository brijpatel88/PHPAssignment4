<?php
// errors/error.php
// Purpose:
// - Shared error page used across the project
// - Displays the $error_message set by calling page

// Set page title for header
$pageTitle = "Error";

// Because error.php is inside /errors/
// and usually included from one level deeper modules,
// basePath goes up one level to root
$basePath = "../";

include('../includes/header.php');
?>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h1 class="text-danger mb-3">Error</h1>

        <!-- Display error message safely -->
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message ?? 'An unknown error occurred.'); ?>
        </div>

        <a class="btn btn-primary" href="<?php echo $basePath; ?>index.php">
            Home
        </a>

    </div>
</div>

<?php include('../includes/footer.php'); ?>