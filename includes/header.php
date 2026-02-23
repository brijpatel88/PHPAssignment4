<?php
// includes/header.php
// Purpose: Shared header + layout shell for all pages.
// - Admin sees sidebar menu.
// - Technician/Customer see full-width content.
// - Top-right shows Portal/Home or Logout depending on session.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? 'SportsPro Technical Support';
$basePath  = $basePath ?? '../';

// Role flags
$isAdmin     = !empty($_SESSION['is_admin']);
$isTech      = !empty($_SESSION['tech_id']);
$isCustomer  = !empty($_SESSION['is_customer']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($pageTitle); ?> - SportsPro Technical Support</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>css/main.css?v=1">

  <style>
    body { background: #f6f7fb; }
    .app-shell { min-height: 100vh; }
    .topbar { background: #0b1320; }
    .brand-title { font-weight: 700; letter-spacing: .2px; }

    .sidebar {
      background: #0f172a;
      min-height: calc(100vh - 56px);
    }
    .sidebar .nav-link {
      color: rgba(255,255,255,.85);
      border-radius: .6rem;
      padding: .6rem .8rem;
      margin: .15rem 0;
    }
    .sidebar .nav-link:hover { background: rgba(255,255,255,.10); color: #fff; }

    .content-wrap { padding: 24px; }
    .page-card { background: #fff; border: 1px solid #e7e9f0; border-radius: 14px; }
  </style>
</head>

<body>
<div class="app-shell">

  <!-- TOP BAR -->
  <nav class="navbar navbar-dark topbar">
    <div class="container-fluid px-3 d-flex align-items-center justify-content-between">
      <span class="navbar-brand mb-0 h1 brand-title">SportsPro Technical Support</span>

      <div class="d-flex gap-2">

        <!-- If ANY role logged in -> show Logout -->
        <?php if ($isAdmin || $isTech || $isCustomer): ?>
          <a class="btn btn-outline-light btn-sm"
             href="<?php echo htmlspecialchars($basePath); ?>auth/logout.php">
            Logout
          </a>
        <?php else: ?>
          <!-- Not logged in -> show Portal -->
          <a class="btn btn-light btn-sm"
             href="<?php echo htmlspecialchars($basePath); ?>auth/portal.php">
            Portal
          </a>
        <?php endif; ?>

        <!-- Home button is OK to keep (it helps navigation) -->
        <a class="btn btn-outline-light btn-sm"
           href="<?php echo htmlspecialchars($basePath); ?>index.php">
          Home
        </a>

      </div>
    </div>
  </nav>

  <!-- MAIN LAYOUT -->
  <div class="container-fluid">
    <div class="row">

      <?php if ($isAdmin): ?>
        <!-- SIDEBAR (admin only) -->
        <aside class="col-12 col-md-3 col-lg-2 sidebar p-3">
          <div class="text-white-50 small mb-2">Admin Menu</div>

          <nav class="nav flex-column">
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>index.php">Dashboard</a>
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>product_manager/index.php">Manage Products</a>
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>technician_manager/index.php">Manage Technicians</a>
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>customer_manager/index.php">Manage Customers</a>
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>incident_manager/index.php">Incident Manager</a>
            <a class="nav-link" href="<?php echo htmlspecialchars($basePath); ?>incident_display/index.php">Display Incidents</a>
          </nav>
        </aside>

        <main class="col-12 col-md-9 col-lg-10 content-wrap">
          <div class="page-card p-4 shadow-sm">

      <?php else: ?>

        <main class="col-12 content-wrap">
          <div class="page-card p-4 shadow-sm" style="max-width: 1100px; margin: 0 auto;">

      <?php endif; ?>