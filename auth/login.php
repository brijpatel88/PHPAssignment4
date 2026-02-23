<?php
// auth/login_action.php
// Purpose: Validate admin login, start session, redirect.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/auth.php');

$email    = trim((string) filter_input(INPUT_POST, 'email'));
$password = trim((string) filter_input(INPUT_POST, 'password'));
$redirect = trim((string) filter_input(INPUT_POST, 'redirect')) ?: '../index.php';

// ✅ Send errors back to portal admin tab
if ($email === '' || $password === '') {
    header('Location: portal.php?tab=admin&error=' . urlencode('Please enter email and password.'));
    exit();
}

if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
    $_SESSION['is_admin'] = true;
    $_SESSION['admin_email'] = $email;

    header('Location: ' . $redirect);
    exit();
}

// ✅ Wrong credentials -> portal admin tab
header('Location: portal.php?tab=admin&error=' . urlencode('Invalid admin login. Try again.'));
exit();

$aminRedirect = trim((string) filter_input(INPUT_GET, 'redirect')) ?: '../index.php';
$errorAdmin    = trim((string) filter_input(INPUT_GET, 'error_admin')) ?: '';
$errorTech      = trim((string) filter_input(INPUT_GET, 'error_tech')) ?: '';
$errorCustomer  = trim((string) filter_input(INPUT_GET, 'error_customer')) ?: '';

// Which tab should open by default? Admin > Technician > Customer
$tab = trim((string) filter_input(INPUT_GET, 'tab'));
if (!in_array($tab, ['admin', 'tech', 'customer'], true)) {
    $tab = 'admin';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SportsPro Technical Support</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .wrap { width: 100%; max-width: 560px; }
        .brand-title { font-weight: 800; letter-spacing: .5px; color: #fff; font-size: 1.7rem; }
        .brand-sub { color: rgba(255,255,255,.75); font-size: .95rem; }
        .card { border: none; border-radius: 18px; box-shadow: 0 15px 40px rgba(0,0,0,.35); }
        .form-control { border-radius: 10px; }
        .nav-pills .nav-link { border-radius: 999px; }
    </style>
</head>
<body>

<div class="wrap">
    <div class="text-center mb-4">
        <div class="brand-title">SportsPro Technical Support</div>
        <div class="brand-sub">Login to continue</div>
    </div>

    <div class="card">
        <div class="card-body p-4">

            <!-- Tabs -->
            <ul class="nav nav-pills gap-2 mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab==='admin'?'active':''; ?>" data-bs-toggle="pill" data-bs-target="#tab-admin" type="button" role="tab">
                        Admin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab==='customer'?'active':''; ?>" data-bs-toggle="pill" data-bs-target="#tab-customer" type="button" role="tab">
                        Customer
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab==='tech'?'active':''; ?>" data-bs-toggle="pill" data-bs-target="#tab-tech" type="button" role="tab">
                        Technician
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <!-- ADMIN -->
                <div class="tab-pane fade <?php echo $tab==='admin'?'show active':''; ?>" id="tab-admin" role="tabpanel">
                    <h5 class="fw-semibold mb-1">Admin Login</h5>
                    <p class="text-muted mb-3">Access admin dashboard modules.</p>

                    <?php if ($errorAdmin !== ''): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($errorAdmin); ?></div>
                    <?php endif; ?>

                    <form action="login_action.php" method="post">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($adminRedirect); ?>">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="admin@sportspro.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>

                        <button class="btn btn-primary w-100 py-2" type="submit">Login as Admin</button>
                    </form>
                </div>

                <!-- CUSTOMER -->
                <div class="tab-pane fade <?php echo $tab==='customer'?'show active':''; ?>" id="tab-customer" role="tabpanel">
                    <h5 class="fw-semibold mb-1">Customer Login</h5>
                    <p class="text-muted mb-3">Enter your email to register products or create incidents.</p>

                    <?php if ($errorCustomer !== ''): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($errorCustomer); ?></div>
                    <?php endif; ?>

                    <form action="customer_login_action.php" method="post">
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="customer@example.com">
                        </div>

                        <button class="btn btn-outline-primary w-100 py-2" type="submit">Continue as Customer</button>
                    </form>
                </div>

                <!-- TECHNICIAN -->
                <div class="tab-pane fade <?php echo $tab==='tech'?'show active':''; ?>" id="tab-tech" role="tabpanel">
                    <h5 class="fw-semibold mb-1">Technician Login</h5>
                    <p class="text-muted mb-3">Login to view and close assigned incidents.</p>

                    <?php if ($errorTech !== ''): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($errorTech); ?></div>
                    <?php endif; ?>

                    <form action="../incident_update/login_action.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="tech@example.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>

                        <button class="btn btn-outline-primary w-100 py-2" type="submit">Login as Technician</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <div class="text-center text-muted small mt-3">
        © <?php echo date('Y'); ?> SportsPro Technical Support
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>