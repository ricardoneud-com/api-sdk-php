<?php

namespace Ricardoneud\API;

class Tools {
    private $client;

    public function __construct(RicardoneudAPI $client) {
        $this->client = $client;
    }

    public function dnsCheck(string $domain, string $recordType) {
        return $this->client->request('GET', 'tools/dnscheck', [], [
            'X-Domain' => $domain,
            'X-Record-Type' => $recordType
        ]);
    }

    public function domainCheck(string $domain) {
        return $this->client->request('GET', 'tools/domaincheck', [], [
            'X-Domain' => $domain
        ]);
    }

    public function mailCheck(string $domain, ?string $dkimSelector = null) {
        $headers = ['X-Domain' => $domain];
        if ($dkimSelector) $headers['X-DKIM-Selector'] = $dkimSelector;
        return $this->client->request('GET', 'tools/mailcheck', [], $headers);
    }

    public function mailHostCheck(string $domain, ?string $dkimSelector = null) {
        $headers = ['X-Domain' => $domain];
        if ($dkimSelector) $headers['X-DKIM-Selector'] = $dkimSelector;
        return $this->client->request('POST', 'tools/mailhostcheck', [], $headers);
    }

    public function subdomainFinder(string $domain) {
        return $this->client->request('GET', 'tools/subdomainfinder', [], [
            'X-Domain' => $domain
        ]);
    }

    public function geoIP(string $ip) {
        return $this->client->request('GET', 'tools/geo-ip', [], [
            'X-IP' => $ip
        ]);
    }
}
