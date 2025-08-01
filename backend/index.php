<?php
// Ustawiamy nagłówek, aby poinformować klienta, że zwracamy dane w formacie JSON.
header('Content-Type: application/json');

// Ustawiamy nagłówek Cross-Origin Resource Sharing (CORS).
// Pozwala to naszej aplikacji frontendowej (działającej na innym porcie) na dostęp do tego API.
// Gwiazdka '*' oznacza, że zezwalamy na żądania z dowolnego źródła (dobre na czas deweloperski).
header('Access-Control-Allow-Origin: *');

// Tworzymy prostą tablicę z przykładowymi danymi.
$data = [
    'message' => 'Witaj, Mariusz! Dane prosto z backendu PHP.',
    'timestamp' => date('Y-m-d H:i:s'),
    'project' => 'Personalizowany Dashboard'
];

// Konwertujemy tablicę PHP na format JSON i wysyłamy ją jako odpowiedź.
echo json_encode($data);
