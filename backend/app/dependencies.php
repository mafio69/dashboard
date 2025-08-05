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

    // Definicja naszego nowego serwisu do obsługi czatu
    ChatService::class => function () {
        return new ChatService();
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