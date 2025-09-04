<?php

// Plik ten służy jako router dla wbudowanego serwera PHP.
// Emuluje on działanie `mod_rewrite` z serwera Apache,
// co jest niezbędne do poprawnego działania frameworków takich jak Slim.

if (php_sapi_name() == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false; // Serwer PHP obsłuży plik statyczny
    }
}
require 'index.php'; // Twój główny plik aplikacji

