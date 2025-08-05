<?php

use App\Middleware\CorsMiddleware;
use App\Middleware\SessionMiddleware;
use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// Ładowanie zmiennych środowiskowych z pliku .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return (function () {
    $containerBuilder = new ContainerBuilder();

    // Ustawienia kontenera DI
    $containerBuilder->addDefinitions(__DIR__ . '/dependencies.php');

    try {
        $container = $containerBuilder->build();
    } catch (Exception $e) {
        die('Error building DI container: ' . $e->getMessage());
    }

    // Tworzenie aplikacji Slim
    $app = $container->get(App::class);

    // Dodanie SessionMiddleware do aplikacji (na początku)
    $app->add(new SessionMiddleware());

    // Rejestracja tras (przed middleware)
    (require __DIR__ . '/routes.php')($app);

    // To middleware jest kluczowe do obsługi zapytań pre-flight (OPTIONS)
    $app->addRoutingMiddleware();

    // Dodanie CorsMiddleware do aplikacji
    $app->add($container->get(CorsMiddleware::class));

    return $app;
})();