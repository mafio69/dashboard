<?php

namespace App\Service;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Oauth2;

class GoogleService
{
    private Google_Client $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    public function getLoginUrl(): string
    {
        $this->client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        $this->client->addScope('email');
        $this->client->addScope('profile');
        return $this->client->createAuthUrl();
    }

    public function handleCallback(string $code): array
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($token);

        $oauth2 = new Google_Service_Oauth2($this->client);
        $userInfo = $oauth2->userinfo->get();

        return [
            'token' => $token,
            'user_info' => [
                'name' => $userInfo->name,
                'given_name' => $userInfo->givenName,
                'email' => $userInfo->email,
                'picture' => $userInfo->picture,
            ]
        ];
    }

    public function getCalendarEvents(array $token): array
    {
        $this->client->setAccessToken($token);
        if ($this->client->isAccessTokenExpired()) {
            // W przyszłości obsłużymy odświeżanie tokenu
        }

        $service = new Google_Service_Calendar($this->client);
        $calendarId = 'primary';
        $optParams = [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        return $results->getItems();
    }
}
