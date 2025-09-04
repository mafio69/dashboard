<?php

use App\Controller\AuthController;
use App\Controller\ChatController;
use App\Controller\ErrorLogController; // Dodajemy nowy kontroler
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app,) {
    error_log('MF-Request method: ' . APP_ENV);
    $app->get('/', "Witaj świecie");

    $app->post('/api/chat', [ChatController::class, 'chat']);
    $app->post('/api/log-error', [ErrorLogController::class, 'logError']); // Nowa trasa do logowania błędów

    // Istniejące trasy do autoryzacji
    $app->group('/auth', function (RouteCollectorProxy $group) {
        $group->get('/login-url', [AuthController::class, 'getLoginUrl']);
        $group->get('/callback', [AuthController::class, 'handleCallback']);
        $group->get('/user', [AuthController::class, 'getUser']);
        $group->get('/calendar-events', [AuthController::class, 'getCalendarEvents']);
        $group->get('/user-info', [AuthController::class, 'userInfo']);
        $group->get('/logout', [AuthController::class, 'logout']);
    });
};