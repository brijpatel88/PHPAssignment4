<?php
// auth/logout.php
// Purpose: Destroy session and send user back to portal.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();

header('Location: portal.php?error=' . urlencode('You have been logged out.'));
exit();