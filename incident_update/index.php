<?php
// incident_update/index.php
// Purpose: Technician login (sets tech session), then redirect to incident list

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/database.php');
require_once('../model/technician_db.php');

$error = trim((string) filter_input(INPUT_GET, 'error'));

if (!empty($_SESSION['tech_id'])) {
    header('Location: incident_list.php');
    exit();
}

$pageTitle = "Technician Login";
$basePath  = "../";
include('../includes/header.php');
?>

<div class="row justify-content-center">
  <div class="col-12 col-md-7 col-lg-5">

    <div class="mb-3">
      <h1 class="mb-1">Technician Login</h1>
      <div class="text-muted">Login to view incidents assigned to you.</div>
    </div>

    <?php if ($error !== ''): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login_action.php" class="card shadow-sm">
      <div class="card-body">

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" type="text" name="email" placeholder="tech@sportspro.com">
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input class="form-control" type="password" name="password" placeholder="password">
        </div>

        <button class="btn btn-primary w-100" type="submit">Login</button>

      </div>
    </form>

  </div>
</div>

<?php include('../includes/footer.php'); ?>