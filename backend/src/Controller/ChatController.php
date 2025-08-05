<?php

namespace App\Controller;

use App\Service\ChatService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ChatController
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function chat(Request $request, Response $response, array $args): Response
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

        // Wyślij wiadomość do serwisu czatu i uzyskaj odpowiedź
        $geminiResponse = $this->chatService->sendMessage($userMessage);

        // Zwróć odpowiedź od AI w formacie JSON
        $response->getBody()->write(json_encode(['reply' => $geminiResponse]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
