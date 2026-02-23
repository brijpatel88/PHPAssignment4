<?php
// util/require_tech_login.php
// Purpose: Protect technician-only pages using session

function require_tech_login(string $basePath = '../'): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['tech_id'])) {
        // send them to technician login page
        header('Location: ' . $basePath . 'incident_update/index.php');
        exit();
    }
}