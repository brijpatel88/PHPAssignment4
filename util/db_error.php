<?php
// util/db_error.php
// Purpose: Central helper to show the database error page consistently.

function show_database_error(string $message, ?Throwable $ex = null): void
{
    $error_message = $message;
    $exception_message = $ex ? $ex->getMessage() : '';
    include(__DIR__ . '/../errors/database_error.php');
    exit();
}