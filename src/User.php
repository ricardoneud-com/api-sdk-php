<?php

namespace Ricardoneud\API;

class User {
    private $client;

    public function __construct(RicardoneudAPI $client) {
        $this->client = $client;
    }

    public function login(string $emailOrUsername, string $password, bool $sendEmail = false) {
        return $this->client->request('POST', 'user/login', [
            'emailOrUsername' => $emailOrUsername,
            'password' => $password,
            'sendEmail' => $sendEmail ? 'true' : 'false'
        ], ['Content-Type' => 'application/json']);
    }

    public function revokeSecret(string $emailOrUsername, string $password, string $secret) {
        return $this->client->request('DELETE', 'user/login', [
            'emailOrUsername' => $emailOrUsername,
            'password' => $password,
            'secret' => $secret
        ]);
    }
}
