<?php
// router.php
// Handles routing for the PHP built-in server (php -S) logic for Railway

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If the requested file exists, serve it as-is
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Otherwise, route everything to index.php
require_once __DIR__ . '/index.php';
?>
