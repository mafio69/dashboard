<?php

namespace App\Service;

use Exception;

class ErrorService
{
    private string $logDir;

    public function __construct()
    {
        $this->logDir = __DIR__ . '/../../logs';
        $this->ensureLogDirectoryExists();
    }

    public function logChatError(Exception $e, string $userMessage): void
    {
        $logMessage = "[Chat Error] " . date('Y-m-d H:i:s') . "\n";
        $logMessage .= "User Message: " . $userMessage . "\n";
        $logMessage .= "Error: " . $e->getMessage() . "\n";
        $logMessage .= "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        $logMessage .= "Stack Trace: " . $e->getTraceAsString() . "\n";
        $logMessage .= "-------------------------------------\n";

        file_put_contents($this->logDir . '/chat_errors.log', $logMessage, FILE_APPEND);
    }

    public function logGeneralError(Exception $e, array $context = []): void
    {
        $logMessage = "[General Error] " . date('Y-m-d H:i:s') . "\n";
        $logMessage .= "Error: " . $e->getMessage() . "\n";
        $logMessage .= "File: " . $e->getFile() . ":" . $e->getLine() . "\n";

        if (!empty($context)) {
            $logMessage .= "Context: " . json_encode($context, JSON_PRETTY_PRINT) . "\n";
        }

        $logMessage .= "Stack Trace: " . $e->getTraceAsString() . "\n";
        $logMessage .= "-------------------------------------\n";

        file_put_contents($this->logDir . '/general_errors.log', $logMessage, FILE_APPEND);
    }

    private function ensureLogDirectoryExists(): void
    {
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }
    }
}
