<?php

use App\Middleware\CorsMiddleware;
use App\Middleware\SessionMiddleware;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// Ładowanie zmiennych środowiskowych z pliku .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

// Ustawienia kontenera DI
$containerBuilder->addDefinitions(__DIR__ . '/dependencies.php');

try {
    $container = $containerBuilder->build();
    AppFactory::setContainer($container);
    $app = AppFactory::create();
    error_log('MF-Request origin: ' . APP_ENV);    // Reszta konfiguracji aplikacji...

    // Rejestracja tras
    (require __DIR__ . '/routes.php')($app);

    // Routing Middleware. Przetwarza żądanie, aby dopasować je do trasy.
    $app->addRoutingMiddleware();

    // Dodanie SessionMiddleware do aplikacji
    $app->add($container->get(SessionMiddleware::class));

    // Error Middleware. Przechwytuje wyjątki i generuje odpowiedzi o błędach.
    $app->addErrorMiddleware(true, true, true);

    // CorsMiddleware. Musi być dodany jako ostatni, aby wykonał się jako pierwszy (zasada LIFO).
    $app->add($container->get(CorsMiddleware::class));

    return $app;
} catch (Exception $e) {
    die('Error building DI container or creating app: ' . $e->getMessage());
}
