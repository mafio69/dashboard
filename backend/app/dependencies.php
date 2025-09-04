<?php

use App\Controller\AuthController;
use App\Controller\ChatController;
use App\Controller\ErrorLogController; // Dodajemy nowy kontroler
use App\Service\ChatService;
use App\Service\ErrorService;
use Gemini\Client;
use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

use App\Service\Google\GoogleAuthService;
use App\Middleware\CorsMiddleware;
use App\Service\Google\GoogleCalendarService;
use Psr\Http\Message\ResponseFactoryInterface;

if (APP_ENV === 'development' || APP_ENV === 'test') {
    define("API_URL", 'http://localhost:8888/');
}

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

    Client::class => function () {
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? '';
        if (empty($apiKey)) {
            throw new RuntimeException('GEMINI_API_KEY is not set in the environment variables.');
        }
        // Poprawny sposób tworzenia klienta Gemini
        return Gemini::client($apiKey);
    },

    // Definicja naszego nowego serwisu do obsługi czatu
    ChatService::class => function (ContainerInterface $container) {
        // Prosimy kontener o dostarczenie nam instancji klienta Gemini.
        // Dzięki temu ChatService nie musi wiedzieć, jak go utworzyć.
        return new ChatService($container->get(Client::class));
    },

    GoogleAuthService::class => function (ContainerInterface $container) {
        $redirectUri = ''.API_URL.'auth/callback';
        return new GoogleAuthService($container->get(Google_Client::class), $redirectUri);
    },

    ChatController::class => function (ContainerInterface $container) {
        $chatService = $container->get(ChatService::class);
        $errorService = $container->get(ErrorService::class);
        return new ChatController($chatService, $errorService);
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

    ErrorLogController::class => function () {
        return new ErrorLogController();
    },

    ErrorService::class => function () {
        return new ErrorService();
    },
    // Tutaj będziemy definiować pozostałe zależności
];