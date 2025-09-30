<?php
// Laravel application entry point
// Set the document root to the public directory
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/umd/public';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';

// Include the Laravel application
require_once __DIR__.'/umd/public/index.php';
?>
