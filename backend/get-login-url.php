<?php
// Wymagamy pliku autoload.php, który został wygenerowany przez Composera.
// Dzięki niemu mamy dostęp do wszystkich klas z zainstalowanych bibliotek.
require_once __DIR__ . '/vendor/autoload.php';

// Tworzymy nowy obiekt klienta Google.
$client = new Google_Client();

// Ustawiamy ścieżkę do naszego pliku z kluczami.
$client->setAuthConfig(__DIR__ . '/secret/credentials.json');

// Ustawiamy URI przekierowania. To jest adres, na który Google odeśle użytkownika
// PO pomyślnym zalogowaniu. Stworzymy plik, który obsłuży ten adres, w następnym kroku.
$client->setRedirectUri('http://localhost:8888/oauth-callback.php');

// Definiujemy "zakres" (scope) - czyli o co prosimy.
// Prosimy o dostęp tylko do odczytu wydarzeń z kalendarza.
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

// Ustawiamy tryb dostępu na "offline", aby otrzymać "refresh token".
// Pozwoli to naszej aplikacji odświeżać dostęp bez konieczności ponownego logowania przez użytkownika za każdym razem.
$client->setAccessType('offline');

// Generujemy unikalny adres URL do autoryzacji.
$authUrl = $client->createAuthUrl();

// Ustawiamy nagłówki, aby umożliwić komunikację z naszym frontendem (CORS)
// i poinformować przeglądarkę, że zwracamy JSON.
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Zwracamy wygenerowany adres w formacie JSON.
echo json_encode(['authUrl' => $authUrl]);
