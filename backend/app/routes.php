<?php

use App\Controller\AuthController;
use App\Controller\ChatController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Trasa do testowania czatu
    $app->get('/api/chat', [ChatController::class, 'chat']);

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