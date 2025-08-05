<?php

namespace App\Controller;

use App\Service\Google\GoogleAuthService;
use App\Service\Google\GoogleCalendarService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    private GoogleAuthService $googleAuthService;
    private GoogleCalendarService $googleCalendarService;

    public function __construct(GoogleAuthService $googleAuthService, GoogleCalendarService $googleCalendarService)
    {
        $this->googleAuthService = $googleAuthService;
        $this->googleCalendarService = $googleCalendarService;
    }

    public function getLoginUrl(Request $request, Response $response): Response
    {
        $authUrl = $this->googleAuthService->getLoginUrl();
        $payload = json_encode(['authUrl' => $authUrl]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function handleCallback(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $code = $queryParams['code'] ?? null;

        if ($code) {
            $result = $this->googleAuthService->handleCallback($code);
            $_SESSION['access_token'] = $result['token'];
            $_SESSION['user_info'] = $result['user_info'];
            return $response->withHeader('Location', 'http://localhost:3000')->withStatus(302);
        }

        return $response->withHeader('Location', 'http://localhost:3000?error=auth_failed')->withStatus(302);
    }
    
    public function logout(Request $request, Response $response): Response
    {
        session_destroy();
        $response->getBody()->write(json_encode(['status' => 'logged_out']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function userInfo(Request $request, Response $response): Response
    {
        if (isset($_SESSION['user_info'])) {
            $payload = json_encode($_SESSION['user_info']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $response->withStatus(401)->withHeader('Content-Type', 'application/json')->withBody((new \Slim\Psr7\Stream(fopen('php://temp', 'r+')))->write(json_encode(['error' => 'Unauthorized'])));
    }

    public function getCalendarEvents(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['access_token'])) {
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json')->withBody((new \Slim\Psr7\Stream(fopen('php://temp', 'r+')))->write(json_encode(['error' => 'Unauthorized'])));
        }

        try {
            $events = $this->googleCalendarService->getUpcomingEvents($_SESSION['access_token']);
            $payload = json_encode($events);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}