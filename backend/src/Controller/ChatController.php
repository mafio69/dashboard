<?php

namespace App\Controller;

use App\Service\ChatService;
use App\Service\ErrorService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ChatController
{
    private ChatService $chatService;
    private ErrorService $errorService;

    public function __construct(ChatService $chatService, ErrorService $errorService)
    {
        $this->chatService = $chatService;
        $this->errorService = $errorService;
    }

    public function chat(Request $request, Response $response): Response
    {
        // Pobierz dane z ciała żądania (ocekujemy formatu JSON)
        $data = json_decode($request->getBody()->getContents(), true);

        // Sprawdź, czy wiadomość została przesłana i nie jest pusta
        if (empty($data['message'])) {
            $errorResponse = ['error' => 'Message field is required and cannot be empty.'];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Pobierz wiadomość użytkownika
        $userMessage = $data['message'];

        try {
            // Wyślij wiadomość do serwisu czatu i uzyskaj odpowiedź
            $geminiResponse = $this->chatService->sendMessage($userMessage);

            // Zwróć odpowiedź od AI w formacie JSON
            $response->getBody()->write(json_encode(['reply' => $geminiResponse]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            // Używamy wstrzykniętego serwisu do logowania błędów
            $this->errorService->logChatError($e, $userMessage);

            // Zwróć odpowiedź z błędem 500
            $errorResponse = ['error' => $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}
