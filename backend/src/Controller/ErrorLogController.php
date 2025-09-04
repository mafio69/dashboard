<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ErrorLogController
{
    public function logError(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $error = $data['error'] ?? 'No error message';
        $errorInfo = $data['errorInfo'] ?? 'No error info';

        $logMessage = "[Frontend Error] " . date('Y-m-d H:i:s') . "\n";
        $logMessage .= "Error: " . print_r($error, true) . "\n";
        $logMessage .= "Component Stack: " . print_r($errorInfo, true) . "\n";
        $logMessage .= "-------------------------------------\n";

        // Upewnij się, że katalog /logs istnieje i jest zapisywalny
        $logDir = __DIR__ . '/../../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        file_put_contents($logDir . '/frontend_errors.log', $logMessage, FILE_APPEND);

        return $response->withStatus(204); // 204 No Content - pomyślnie przyjęliśmy dane, ale nie mamy nic do odesłania
    }
}
