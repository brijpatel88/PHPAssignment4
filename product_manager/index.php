<?php
// product_manager/index.php
// Purpose: Controller for Manage Products (Projects 8-1 + 10-1)
// - Uses a switch statement to select action (8-1)
// - Improves release date handling (10-1)

require_once('../model/database.php');
require_once('../model/product_db.php');

// Get action from POST first (form submits), otherwise GET (links)
$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
}
if ($action === null) {
    $action = 'list_products'; // default action
}

switch ($action) {

    // -------------------------
    // Show product list
    // -------------------------
    case 'list_products':
        $products = get_products();
        include('product_list.php');
        break;

    // -------------------------
    // Show Add Product form
    // -------------------------
    case 'show_add_form':
        include('add_product_form.php');
        break;

    // -------------------------
    // Add Product (accept any standard date format)
    // -------------------------
    case 'add_product':

        // Read + trim inputs (safe)
        $code        = trim((string) filter_input(INPUT_POST, 'code'));
        $name        = trim((string) filter_input(INPUT_POST, 'name'));
        $version     = trim((string) filter_input(INPUT_POST, 'version'));
        $releaseDate = trim((string) filter_input(INPUT_POST, 'releaseDate'));

        // Basic validation (required fields)
        if ($code === '' || $name === '' || $version === '' || $releaseDate === '') {
            $error_message = 'All fields are required. Please enter product code, name, version, and release date.';
            include('../errors/error.php');
            exit();
        }

        // Project 10-1: allow ANY standard date format
        // strtotime() accepts many formats: "2026-02-08", "Feb 8 2026", "02/08/2026", etc.
        $timestamp = strtotime($releaseDate);
        if ($timestamp === false) {
            $error_message = 'Invalid release date. Please enter a valid date format (example: 2026-02-08 or Feb 8 2026).';
            include('../errors/error.php');
            exit();
        }

        // Store in DB-friendly format (DATE)
        $releaseDateForDb = date('Y-m-d', $timestamp);

        // Insert into database
        add_product($code, $name, $version, $releaseDateForDb);

        // Redirect back to list
        header('Location: index.php');
        exit();

    // -------------------------
    // Delete Product
    // -------------------------
    case 'delete_product':

        $code = trim((string) filter_input(INPUT_POST, 'code'));
        if ($code === '') {
            $error_message = 'Missing product code.';
            include('../errors/error.php');
            exit();
        }

        delete_product($code);

        // Redirect back to list
        header('Location: index.php');
        exit();

    // -------------------------
    // Unknown action
    // -------------------------
    default:
        $error_message = 'Unknown action: ' . htmlspecialchars($action);
        include('../errors/error.php');
        exit();
}