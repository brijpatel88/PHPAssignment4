<?php
// util/require_login.php
// Purpose:Protect pages. If admin is not logged in, redirect to login page.
// - Require login for admin-only pages
// - Redirects to login page if not logged in

function require_login(string $basePath): void {
   // Start session once (safe)
   if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // if not logged in, send to login page
    if (empty($_SESSION['is_admin'])) {
     // Redirect back to the requested page after login
        $currentUrl = $_SERVER['REQUEST_URI'] ?? ($basePath . 'index.php');
        $loginUrl = $basePath . "auth/login.php?redirect=" . urlencode($currentUrl);


        header("Location: $loginUrl" );
        exit();
    }

}
    