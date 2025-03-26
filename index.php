<?php
// index.php (in your project root)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Redirect to the "public" directory
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    // Serve existing files directly (e.g., CSS, JS, images)
    return require __DIR__ . '/public' . $uri;
}

// Route all other requests to Laravel's front controller
require __DIR__ . '/public/index.php';
