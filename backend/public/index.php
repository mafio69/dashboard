<?php

// Włączamy wyświetlanie wszystkich błędów na potrzeby debugowania
use Slim\App;

define('APP_ENV', getenv('APP_ENV') ?: 'development');
error_log('MF-StartAPP: ' . APP_ENV);
if (APP_ENV === 'development' || APP_ENV === 'test') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/** @var App $app */
$app = require __DIR__.'/../app/bootstrap.php';
error_log('MF-StartBOOT: ' . APP_ENV);
$app->run();