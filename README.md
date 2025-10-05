# Composer Module for API Usage

This guide explains how to use the **official Composer PHP module** to interact with the API. It covers **installation, setup, authentication, and using the main modules** such as games, tools, reseller, and user management.

> ⚠️ **Important:** Always verify which endpoints are available in which version. Not all endpoints exist in every version, and some features are only available from v3 and above. Make sure your project uses a supported API version.

## Installation

```bash
composer require ricardoneud.com/api
```

## Initialization

The client can be initialized with either an **API Key** or a **Secret token**:

```php
<?php

require 'vendor/autoload.php';

use Ricardoneud\API\RicardoneudAPI;

$api = new RicardoNeudAPI([
    'apiKey' => 'your-api-key', // OR use 'secret' => 'your-secret'
    'version' => 'v4'
]);
```

### Changing Version

```php
$api->setVersion('v4'); // Verify which endpoints are supported in v4
```

## Authentication

### API Key

1. Log in at [Ricardoneud.com](https://auth.ricardoneud.com/login)
2. Go to **Dashboard → API Keys**
3. Click **Create API Key**, configure permissions, and set environment to `Production`.
4. Use the API Key in your client:

```php
$api->setApiKey('your-api-key');
```

### Secret Token (Login-based)

Short-lived tokens provide session-based access (valid for 24 hours).

```php
$loginResponse = $api->user->login('usernameOrEmail', 'password', true);
echo $loginResponse['secret']; // Use this token in subsequent requests
```

```php
$api = new RicardoNeudAPI(['secret' => 'your-secret']);
```

You can revoke tokens when needed:

```php
$api->user->revokeSecret('usernameOrEmail', 'password', 'your-secret');
```

## Core Modules

### Games

```php
$server = $api->games->minecraft('play.hypixel.net');
$fivemServer = $api->games->fivem('127.0.0.1', '30120');
```

### Tools

```php
$dns = $api->tools->dnsCheck('example.com', 'A');
$domain = $api->tools->domainCheck('google.com');
$subdomains = $api->tools->subdomainFinder('example.com');
$geoip = $api->tools->geoIP('8.8.8.8');
```

Mail verification:

```php
$mail = $api->tools->mailCheck('example.com', 'selector');
$mailHost = $api->tools->mailHostCheck('example.com');
```

### Reseller

```php
$api->reseller->checkLicense('LICENSE_KEY');

$api->reseller->generateLicense([
    'registeredTo' => 'John Doe',
    'domainOrIp' => 'example.com',
    'status' => 'active',
    'productId' => 123,
    'projectId' => 456
]);

$api->reseller->updateLicense('LICENSE_KEY', ['status' => 'inactive']);
$api->reseller->deleteLicense('LICENSE_KEY');
```

### User

```php
$loginResponse = $api->user->login('usernameOrEmail', 'password', true);
$api->user->revokeSecret('usernameOrEmail', 'password', 'secret-token');
```

### OAuth

```php
$token = $api->oauth2->getAccessToken('code', 'redirectUri', 'clientId', 'clientSecret');
$profile = $api->oauth2->getProfile($token['access_token']);
```

## Request Handling

All HTTP requests are handled internally with Guzzle, including error handling. Every method returns an **array** of the response.

```php
try {
    $result = $api->tools->geoIP('8.8.8.8');
    print_r($result);
} catch (\Exception $error) {
    echo $error->getCode() . ' ' . $error->getMessage();
}
```

## Notes

* You must provide either an **API Key** or a **Secret token**.
* Secret tokens expire after 24 hours and are visible in your dashboard.
* API Key and Secret are mutually exclusive; setting one clears the other.
* Always check the supported API version to ensure endpoint compatibility.
