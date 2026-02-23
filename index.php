<?php
// index.php (ROOT)
// Purpose: Admin dashboard landing page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ If not admin, go to portal (admin tab)
if (empty($_SESSION['is_admin'])) {
    header('Location: auth/portal.php?tab=admin');
    exit();
}

$pageTitle = "Dashboard";
$basePath  = ""; // root
include('includes/header.php');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="mb-0">Dashboard</h1>
        <div class="text-muted mt-1">SportsPro Technical Support</div>
    </div>

    <span class="badge text-bg-success px-3 py-2">
        Project is running ✅
    </span>
</div>

<div class="row g-3">

    <!-- Manage Products -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="border rounded-4 p-4 bg-white h-100">
            <h5 class="mb-2">Manage Products</h5>
            <p class="text-muted mb-3">Add, view, and delete products.</p>
            <a href="product_manager/index.php" class="btn btn-primary btn-sm">Open</a>
        </div>
    </div>

    <!-- Manage Technicians -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="border rounded-4 p-4 bg-white h-100">
            <h5 class="mb-2">Manage Technicians</h5>
            <p class="text-muted mb-3">View technicians, add new, delete.</p>
            <a href="technician_manager/index.php" class="btn btn-primary btn-sm">Open</a>
        </div>
    </div>

    <!-- Manage Customers -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="border rounded-4 p-4 bg-white h-100">
            <h5 class="mb-2">Manage Customers</h5>
            <p class="text-muted mb-3">Search customers and update details.</p>
            <a href="customer_manager/index.php" class="btn btn-primary btn-sm">Open</a>
        </div>
    </div>

    <!-- Incident Manager -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="border rounded-4 p-4 bg-white h-100">
            <h5 class="mb-2">Incident Manager</h5>
            <p class="text-muted mb-3">Assign technicians and manage incidents.</p>
            <a href="incident_manager/index.php" class="btn btn-primary btn-sm">Open</a>
        </div>
    </div>

    <!-- Display Incidents -->
     <div class="col-12 col-md-6 col-xl-4">
        <div class="border rounded-4 p-4 bg-white h-100">
            <h5 class="mb-2">Display Incidents</h5>
            <p class="text-muted mb-3">View assigned and unassigned incidents.</p>
            <a href="incident_display/index.php" class="btn btn-primary btn-sm">Open</a>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>