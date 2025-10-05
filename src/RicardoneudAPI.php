<?php

namespace Ricardoneud\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RicardoNeudAPI {
    private $apiKey;
    private $secret;
    private $baseURL;
    private $version;
    private $client;

    public $games;
    public $tools;
    public $reseller;
    public $user;
    public $oauth2;

    public function __construct(array $config = []) {
        $this->apiKey = $config['apiKey'] ?? null;
        $this->secret = $config['secret'] ?? null;
        $this->baseURL = $config['baseURL'] ?? 'https://api.ricardoneud.com';
        $this->version = $config['version'] ?? 'v4';

        $this->client = new Client([
            'base_uri' => "{$this->baseURL}/{$this->version}/",
            'timeout' => $config['timeout'] ?? 30.0,
            'headers' => $this->getHeaders()
        ]);

        $this->games = new Games($this);
        $this->tools = new Tools($this);
        $this->reseller = new Reseller($this);
        $this->user = new User($this);
        $this->oauth2 = new OAuth2($this);
    }

    public function getHeaders(): array {
        $headers = [];
        if ($this->secret) $headers['Authorization'] = "Bearer {$this->secret}";
        else if ($this->apiKey) $headers['Basic'] = $this->apiKey;
        return $headers;
    }

    public function request(string $method, string $endpoint, array $data = [], array $customHeaders = []) {
        try {
            $options = ['headers' => array_merge($this->getHeaders(), $customHeaders)];

            if (strtoupper($method) === 'GET') $options['query'] = $data;
            else $options['json'] = $data;

            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function setVersion(string $version): self {
        $this->version = $version;
        return $this;
    }

    public function setApiKey(string $apiKey): self {
        $this->apiKey = $apiKey;
        $this->secret = null;
        return $this;
    }

    public function setSecret(string $secret): self {
        $this->secret = $secret;
        $this->apiKey = null;
        return $this;
    }
}
