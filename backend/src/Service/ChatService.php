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
    private string $apiKey;
    private Client $geminiClient;

    public function __construct()
    {
        $this->apiKey = $_ENV['GEMINI_API_KEY'] ?? '';
        $this->geminiClient = Client::factory($this->apiKey);
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function sendMessage(string $message): string
    {
        if (empty($this->apiKey)) {
            return 'Error: API key is not configured.';
        }

        try {
            $response = $this->geminiClient->geminiPro()->generateContent([$message]);
            return $response->text();
        } catch (\Exception $e) {
            // W przypadku błędu zwracamy komunikat o błędzie
            return 'Error communicating with Gemini API: ' . $e->getMessage();
        }
    }
}