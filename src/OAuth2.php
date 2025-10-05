<?php

namespace Ricardoneud\API;

class OAuth2 {
    private $client;

    public function __construct(RicardoneudAPI $client) {
        $this->client = $client;
    }

    public function getAccessToken(string $code, string $redirectUri, string $clientId, string $clientSecret) {
        return $this->client->request('POST', 'oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ]);
    }

    public function getProfile(string $accessToken) {
        return $this->client->request('GET', 'oauth2/profile', [], [
            'AccessToken' => $accessToken
        ]);
    }
}
