<?php
// util/require_customer_login.php
// Purpose: Protect customer portal pages (requires customer session)

function require_customer_login(string $basePath = '../'): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Already logged in as customer -> allow access
    if (!empty($_SESSION['is_customer'])) {
        return;
    }

    // Where the user was trying to go (so we can return after login)
    $current = $_SERVER['REQUEST_URI'] ?? ($basePath . 'customer_portal/index.php');

    // Send to ONE portal page with the Customer tab open
    $url = $basePath . 'auth/portal.php'
        . '?tab=customer'
        . '&redirect=' . urlencode($current);

    header('Location: ' . $url);
    exit();
}