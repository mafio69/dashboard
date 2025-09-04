<?php

namespace App\Service;

use Gemini\Client;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\MimeType;
use Gemini\Enums\Role;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Data\SafetySetting;

class ChatService
{
    private Client $geminiClient;

    public function __construct(Client $geminiClient)
    {
        $this->geminiClient = $geminiClient;
    }

    public function sendMessage(string $message): string
    {

        try {
            $response = $this->geminiClient->generativeModel('gemini-1.5-pro-latest')->generateContent([$message]);
            return $response->text();
        } catch (\Exception $e) {
            // Rzucamy wyjątek, aby kontroler mógł go obsłużyć
            throw new \Exception('Error communicating with Gemini API: ' . $e->getMessage());
        }
    }
}