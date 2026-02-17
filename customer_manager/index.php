<?php
// customer_manager/index.php
// Purpose: simple entry page that shows the search form

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css?v=1">
    <title>Customer Manager</title>
</head>
<body>

<h1>Search Customers</h1>

<!-- This form sends last name to customer_search.php -->
<form action="customer_search.php" method="get">
    Last Name:
    <input type="text" name="lastName">
    <button type="submit">Search</button>
</form>

<p><a href="/PHPAssignment2">Home</a></p>

</body>
</html>