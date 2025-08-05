<?php

namespace App\Controller;

use App\Service\Google\GoogleCalendarService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiController
{
    private GoogleCalendarService $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function getCalendarEvents(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['access_token'])) {
            return $response->withStatus(401);
        }

        try {
            $events = $this->calendarService->getUpcomingEvents($_SESSION['access_token']);
            $payload = json_encode($events);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Prosta obsługa błędu, np. gdy token wygaśnie
            unset($_SESSION['access_token']);
            unset($_SESSION['user_info']);
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }

    public function getUserInfo(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['user_info'])) {
            return $response->withStatus(401);
        }

        $payload = json_encode($_SESSION['user_info']);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
