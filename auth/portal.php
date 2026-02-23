<?php
// auth/portal.php
// Purpose: ONE login page with 3 options (Admin / Technician / Customer)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to correct dashboard
if (!empty($_SESSION['is_admin'])) {
    header('Location: ../index.php');
    exit();
}
if (!empty($_SESSION['tech_id'])) {
    header('Location: ../incident_update/incident_list.php');
    exit();
}
if (!empty($_SESSION['is_customer']) || !empty($_SESSION['customer_email'])) {
    header('Location: ../customer_portal/index.php');
    exit();
}

$tab   = trim((string) filter_input(INPUT_GET, 'tab')) ?: 'admin'; // admin | tech | customer
$error = trim((string) filter_input(INPUT_GET, 'error'));

// OPTIONAL: where to go after login (used mainly by customer protected pages)
$redirect = trim((string) filter_input(INPUT_GET, 'redirect'));
if ($redirect === '') {
    // Default redirects
    if ($tab === 'customer') $redirect = '../customer_portal/index.php';
    if ($tab === 'tech')     $redirect = '../incident_update/incident_list.php';
    if ($tab === 'admin')    $redirect = '../index.php';
}

$adminRedirect = '../index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Portal - SportsPro Technical Support</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Background (clean, modern) */
    body{
      min-height:100vh;
      background:
        radial-gradient(1200px 600px at 10% 10%, rgba(37,99,235,.20), transparent 55%),
        radial-gradient(900px 500px at 90% 15%, rgba(99,102,241,.18), transparent 55%),
        linear-gradient(180deg, #0b1320 0%, #f6f7fb 55%);
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    /* Top bar like your admin theme */
    .topbar{
      background:#0b1320;
      color:#fff;
      padding:14px 0;
      box-shadow: 0 8px 24px rgba(0,0,0,.20);
    }
    .brand{
      font-weight:800;
      letter-spacing:.2px;
      margin:0;
      font-size:1.15rem;
    }
    .brand-sub{
      color:rgba(255,255,255,.70);
      font-size:.9rem;
      margin:0;
    }

    /* Main card */
    .portal-wrap{ max-width: 980px; margin: 0 auto; padding: 28px 12px 48px; }
    .portal-card{
      border: 1px solid rgba(15,23,42,.08);
      border-radius: 18px;
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(6px);
      box-shadow: 0 18px 50px rgba(15,23,42,.15);
      overflow: hidden;
    }
    .portal-card-header{
      padding: 18px 22px;
      border-bottom: 1px solid rgba(15,23,42,.08);
      background: linear-gradient(180deg, rgba(248,250,252,.9), rgba(255,255,255,.92));
    }

    /* Segmented tabs */
    .seg-tabs{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin: 0;
      padding: 0;
      list-style:none;
    }
    .seg-tabs a{
      text-decoration:none;
      padding:10px 14px;
      border-radius: 999px;
      border: 1px solid rgba(15,23,42,.15);
      color:#0f172a;
      background:#fff;
      font-weight:600;
      font-size:.95rem;
    }
    .seg-tabs a.active{
      background:#2563eb;
      border-color:#2563eb;
      color:#fff;
      box-shadow: 0 10px 20px rgba(37,99,235,.22);
    }

    .portal-body{ padding: 22px; }

    .form-control{
      border-radius: 12px;
      padding: 10px 12px;
    }
    .btn-primary{
      background:#2563eb;
      border-color:#2563eb;
      border-radius:12px;
      padding:10px 14px;
      font-weight:600;
    }
    .btn-primary:hover{
      background:#1d4ed8;
      border-color:#1d4ed8;
    }

    .hint{ color: #64748b; }
    .footer-note{
      color:#64748b;
      font-size:.85rem;
      padding: 14px 22px 18px;
      border-top: 1px solid rgba(15,23,42,.08);
      text-align:center;
      background: rgba(248,250,252,.65);
    }
  </style>
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
  <div class="container d-flex align-items-center justify-content-between">
    <div>
      <p class="brand">SportsPro Technical Support</p>
      <p class="brand-sub">Login Portal (Admin / Technician / Customer)</p>
    </div>
  </div>
</div>

<div class="portal-wrap">
  <div class="portal-card">

    <div class="portal-card-header">
      <ul class="seg-tabs">
        <li><a class="<?php echo ($tab==='admin')?'active':''; ?>" href="portal.php?tab=admin">Admin</a></li>
        <li><a class="<?php echo ($tab==='tech')?'active':''; ?>" href="portal.php?tab=tech">Technician</a></li>
        <li><a class="<?php echo ($tab==='customer')?'active':''; ?>" href="portal.php?tab=customer">Customer</a></li>
      </ul>
    </div>

    <div class="portal-body">

      <?php if ($error !== ''): ?>
        <div class="alert alert-danger mb-4">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <!-- ADMIN -->
      <?php if ($tab === 'admin'): ?>
        <h2 class="h4 mb-1">Admin Login</h2>
        <div class="hint mb-4">Login to access the Admin Dashboard.</div>

        <form action="login_action.php" method="post" class="row g-3" autocomplete="off">
          <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($adminRedirect); ?>">

          <div class="col-12">
            <label class="form-label">Email</label>
            <input class="form-control" type="text" name="email" placeholder="admin@sportspro.com">
          </div>

          <div class="col-12">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" placeholder="••••••••">
          </div>

          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login as Admin</button>
          </div>
        </form>
      <?php endif; ?>

      <!-- TECH -->
      <?php if ($tab === 'tech'): ?>
        <h2 class="h4 mb-1">Technician Login</h2>
        <div class="hint mb-4">Login to view incidents assigned to you.</div>

        <form action="../incident_update/login_action.php" method="post" class="row g-3" autocomplete="off">
          <div class="col-12">
            <label class="form-label">Email</label>
            <input class="form-control" type="text" name="email" placeholder="tech@sportspro.com">
          </div>

          <div class="col-12">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" placeholder="••••••••">
          </div>

          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login as Technician</button>
          </div>
        </form>
      <?php endif; ?>

      <!-- CUSTOMER -->
      <?php if ($tab === 'customer'): ?>
        <h2 class="h4 mb-1">Customer Login</h2>
        <div class="hint mb-4">Login to access the Customer Portal.</div>

        <form action="customer_login_action.php" method="post" class="row g-3" autocomplete="off">
          <!-- Where to go after login (supports require_customer_login redirect) -->
          <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

          <div class="col-12">
            <label class="form-label">Email</label>
            <input class="form-control" type="text" name="email" placeholder="customer@email.com">
          </div>

          <div class="col-12">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" placeholder="••••••••">
          </div>

          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login as Customer</button>
          </div>
        </form>
      <?php endif; ?>

    </div>

    <div class="footer-note">
      © <?php echo date('Y'); ?> SportsPro Technical Support
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>