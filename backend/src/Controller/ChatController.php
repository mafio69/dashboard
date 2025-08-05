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

    public function chat(Request $request, Response $response, array $args):
    Response
    {
        // Na razie nie pobieramy wiadomości od użytkownika, tylko testujemy
        $message = "Hello, Gemini!";
        $geminiResponse = $this->chatService->sendMessage($message);

        $response->getBody()->write(json_encode(['reply' => $geminiResponse]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
