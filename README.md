PHP SDK for WEPHONE API
============

JSON-RPC 2.0 PHP class, to use with WEPHONE API.

* **API documentation**: http://www.wephone.io/docs/
* **SDK Installation guide**: see INSTALLING.php.md
* **JSON-RPC 2.0 Specification**: http://www.jsonrpc.org/specification

* Easy to use Client class, built for **PHP 5.4+**
* Can be used for both the [API][docs-api] and [Real-time][docs-realtime] calls
* Requires: `php5-curl`

[docs-api]: http://wephone.io/docs/
[docs-realtime]: http://wephone.io/docs/real-time/

## Composer

You should use Composer (https://getcomposer.org/) to manage your PHP dependencies.
If you do not have a `composer.json` file yet, create one at the root of your project, download Composer, and launch `composer update`.

The `composer.json` file should look like this:
```json
{
    "name": "wephone/sdk-php",
    "autoload": {
        "psr-0" : {
            "WEPHONE" : "src"
        }
    }
}
```

Add all the libraries you need in `composer.json`. Do not forget to run `composer update` each time you edit the file.

Then you just need to include one file in your code:
```php
<?php

require 'vendor/autoload.php';
```


# System API

System API is the API for initializing a new enterprise from client data. 
This is the API can be called even if not logged on to the system.

## Usage

**Init**
```php
$sysClient = new \WEPHONE\SDK\SystemClient;
$sysClient->init("api-key-code");
```


********************************************************************************


### ENTERPRISE
### Create a new enterprise

```php
$enterpriseData = array(
    "name" => "Enterprise 1",
    "domain" => "domain1",
    "admin_email" => "email@domain.com",
    "admin_password" => "password",
    "subscription_pack" => "basic",
    "did" => '842418001800'
);
$sysClient->call('enterprise.create', $enterpriseData);
```

### Enable an enterprise

```php
$sysClient->call('enterprise.enable', array("domain" => "domain1"));
```

### Disable an enterprise

```php
$sysClient->call('enterprise.disable', array("domain" => "domain1"));
```

### Get information of enterprise

```php
$sysClient->call('enterprise.get_info', array("domain" => "domain1"));
```


### USER
### Check email exists

Return an array(domain, email) if email already exist and null if user not exist

```php
$sysClient->call('enterprise.get_user', array(
    "domain" => "domain1", 
    "email" => "email@domain.com"
));

### Get preauthenticated link

```php
$sysClient->call('user.get_preauthenticated_url', array(
    "domain" => "domain1", 
    "email" => "email@domain.com"
));
```

********************************************************************************


### NUMBER
### Get list of numbers available

Input agruments: 
- number_prefix: Must be at less most 2 characters
- limit: [ingeter|null]. It's null if you want to return all numbers available

```php
$sysClient->call('number.get_available_list', array("number_prefix" => "8424", "limit" => 10));
```

********************************************************************************



# Enterprise API


## Usage

**Init**
```php
$client = new \WEPHONE\SDK\Client;
$client->init("api-key-code");
```

********************************************************************************


### USER
### Get List of Users

```php
$result = $client->call('user.list_all', array());
```

### Create new user

```php
$result = $client->call('user.create', array('first', 'last', 'email@domain.com'));
```

### Remove an user

```php
$result = $client->call('user.remove', array('user_public_id'));
```

********************************************************************************


### NUMBER
### Get List of Numbers

```php
$result = $client->call('number.list_all', array());
```

### Buy new number

```php
$result = $client->call('number.buy', array('country_code_2letter', 'number_prefix'));
```

### Return a number

```php
$result = $client->call('number.return', array('returned_number'));
```

### Route a number

```php
$routingData = array(
    "application"=> "call_phone_number", 
    "params"=> array("number"=> "111")
);
$result = $client->call('number.set_route', array('routed_number', $routingData));
```

********************************************************************************


### CALL QUEUE
### Get List of queues

```php
$result = $client->call('queue.list_all', array());
```



********************************************************************************


