<?php

foreach ($_SERVER as $key => $value) {
    if (is_string($value)) {
        putenv("$key=" . trim($value));
    }
}

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    $ext = pathinfo($uri, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js'  => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff2' => 'font/woff2',
    ];
    header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
    readfile(__DIR__ . '/../public' . $uri);
    exit;
}

require __DIR__ . '/../public/index.php';
