<?php
// incident_create/index.php
// Purpose: Customer enters email to start creating an incident

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css?v=1">
    <title>Create Incident - Customer Login</title>
</head>
<body>

<h1>Create Incident - Customer Login</h1>

<form action="create_incident.php" method="post">
    <label>Email:</label>
    <input type="text" name="email">
    <button type="submit">Login</button>
</form>

<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>
