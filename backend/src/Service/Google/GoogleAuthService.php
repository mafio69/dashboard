<?php

namespace App\Service\Google;

use Google_Client;
use Google_Service_Oauth2;

class GoogleAuthService
{
    private Google_Client $client;
    private string $redirectUri;

    public function __construct(Google_Client $client, string $redirectUri)
    {
        $this->client = $client;
        $this->redirectUri = $redirectUri;
    }

    public function getLoginUrl(): string
    {
        $this->client->setRedirectUri($this->redirectUri);
        $this->client->addScope('email');
        $this->client->addScope('profile');
        $this->client->addScope('https://www.googleapis.com/auth/calendar.readonly');
        return $this->client->createAuthUrl();
    }

    public function handleCallback(string $code): array
    {
        $this->client->setRedirectUri($this->redirectUri);
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
}