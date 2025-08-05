<?php

use App\Controller\ChatController;
use App\Service\ChatService;
use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

use Google_Client;
use App\Service\Google\GoogleAuthService;
use App\Middleware\CorsMiddleware;
use App\Controller\AuthController;
use App\Service\Google\GoogleCalendarService;
use Psr\Http\Message\ResponseFactoryInterface;

return [
    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },
    // Definicja aplikacji Slim
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },

    Google_Client::class => function (ContainerInterface $container) {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../secret/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    },

    // Definicja klienta Gemini
    \Gemini\Client::class => function () {
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? '';
        if (empty($apiKey)) {
            // W idealnym świecie chcielibyśmy, aby aplikacja zgłosiła błąd, jeśli klucz API nie jest dostępny.
            // Rzucenie wyjątku jest dobrym podejściem, ponieważ zatrzyma to działanie aplikacji
            // i poinformuje dewelopera o problemie konfiguracyjnym.
            throw new \RuntimeException('GEMINI_API_KEY is not set in the environment variables.');
        }
        // Używamy fabryki dostarczonej przez bibliotekę Gemini do stworzenia klienta.
        // Jest to zgodne z dobrymi praktykami, ponieważ fabryka zajmuje się całym
        // skomplikowanym procesem tworzenia obiektu.
        return \Gemini\Client::factory()
            ->withApiKey($apiKey)
            ->make();
    },

    // Definicja naszego nowego serwisu do obsługi czatu
    ChatService::class => function (ContainerInterface $container) {
        // Prosimy kontener o dostarczenie nam instancji klienta Gemini.
        // Dzięki temu ChatService nie musi wiedzieć, jak go utworzyć.
        return new ChatService($container->get(\Gemini\Client::class));
    },

    GoogleAuthService::class => function (ContainerInterface $container) {
        $redirectUri = 'http://localhost:8888/auth/callback';
        return new GoogleAuthService($container->get(Google_Client::class), $redirectUri);
    },

    ChatController::class => function (ContainerInterface $container) {
        return new ChatController($container->get(ChatService::class));
    },

    CorsMiddleware::class => function (ContainerInterface $container) {
        return new CorsMiddleware($container->get(ResponseFactoryInterface::class));
    },

    GoogleCalendarService::class => function (ContainerInterface $container) {
        return new GoogleCalendarService($container->get(Google_Client::class));
    },

    AuthController::class => function (ContainerInterface $container) {
        return new AuthController(
            $container->get(GoogleAuthService::class),
            $container->get(GoogleCalendarService::class)
        );
    },

    // Tutaj będziemy definiować pozostałe zależności
];