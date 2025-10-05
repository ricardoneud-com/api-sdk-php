<?php

namespace Ricardoneud\API;

class Reseller {
    private $client;

    public function __construct(RicardoneudAPI $client) {
        $this->client = $client;
    }

    public function checkLicense(string $licenseKey) {
        return $this->client->request('GET', "reseller/{$licenseKey}/check");
    }

    public function generateLicense(array $data) {
        return $this->client->request('POST', 'reseller/licenses/generate', [], [
            'X-Registered-To' => $data['registeredTo'],
            'X-Domain-Or-IP' => $data['domainOrIp'],
            'X-Status' => $data['status'],
            'X-Product-Id' => $data['productId'],
            'X-Project-Id' => $data['projectId']
        ]);
    }

    public function updateLicense(string $licenseKey, array $data) {
        $headers = [];
        if (isset($data['registeredTo'])) $headers['X-Registered-To'] = $data['registeredTo'];
        if (isset($data['domainOrIp'])) $headers['X-Domain-Or-IP'] = $data['domainOrIp'];
        if (isset($data['status'])) $headers['X-Status'] = $data['status'];
        if (isset($data['productId'])) $headers['X-Product-Id'] = $data['productId'];
        if (isset($data['projectId'])) $headers['X-Project-Id'] = $data['projectId'];
        return $this->client->request('PUT', "reseller/{$licenseKey}/update", [], $headers);
    }

    public function deleteLicense(string $licenseKey) {
        return $this->client->request('DELETE', "reseller/{$licenseKey}/delete");
    }
}
