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
            $response = $this->geminiClient->geminiPro()->generateContent([$message]);
            return $response->text();
        } catch (\Exception $e) {
            // W przypadku błędu zwracamy komunikat o błędzie
            return 'Error communicating with Gemini API: ' . $e->getMessage();
        }
    }
}