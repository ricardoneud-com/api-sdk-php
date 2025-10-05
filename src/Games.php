<?php

namespace Ricardoneud\API;

class Games {
    private $client;

    public function __construct(RicardoneudAPI $client) {
        $this->client = $client;
    }

    public function minecraft(string $address, string $port = '25565') {
        return $this->client->request('GET', 'games/minecraft/lookup', [], [
            'X-Address' => $address,
            'X-Port' => $port
        ]);
    }

    public function fivem(string $address, string $port = '30120') {
        return $this->client->request('GET', 'games/fivem/lookup', [], [
            'X-Address' => $address,
            'X-Port' => $port
        ]);
    }
}
