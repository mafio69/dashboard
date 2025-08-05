<?php

namespace App\Service\Google;

use Google_Client;
use Google_Service_Calendar;

class GoogleCalendarService
{
    private Google_Client $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    public function getUpcomingEvents(array $token, int $maxResults = 10): array
    {
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            // Tutaj w przyszłości dodamy logikę odświeżania tokenu, jeśli będzie potrzebna.
            // Na razie, jeśli wygaśnie, użytkownik będzie musiał zalogować się ponownie.
            // Można by rzucić wyjątek, który obsłuży kontroler.
        }

        $service = new Google_Service_Calendar($this->client);
        $calendarId = 'primary';
        $optParams = [
            'maxResults' => $maxResults,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        return $results->getItems();
    }
}
