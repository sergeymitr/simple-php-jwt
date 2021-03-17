# Simple PHP JWT

The library serves a single purpose: making JWT easier to work with.

## Requirements
- PHP 7.4 or higher.

## Installation
Run this command to install the library via Composer:
```bash
composer require sergeymitr/simple-php-jwt
```

## Usage

### Creating and Encoding the Token
Use `Token::create()` factory method to create a new token:
```php
use Sergeymitr\SimpleJWT\Token;

$token = Token::create();
```

The token doesn't hold any data, so we'll need to fill that out:
```php
$token->setIssuer('Sergeymitr\SimpleJWT')
    ->setSubject('Test Sample')
    ->setAudience('PHPUnit')
    ->setExpiration(new \DateTime('2020-02-02'))
    ->setNotBefore(new \DateTime('2020-01-01'))
    ->setIssuedAt(new DateTime('2020-01-15'))
    ->setID('sample-id');
```
All the data is optional, you only fill out what you need.
These methods define the claim names described by [RFC 7519](https://tools.ietf.org/html/rfc7519).

You can also add custom values to your token:
```php
$token->setCustomPayload('key', 'value');
```

To encode the token you will need use the `Token` object, and a secret string to encode it with.
```php
use Sergeymitr\SimpleJWT\Encoder;

$encoded_token = Encoder::do($token, 'secret');
```
The `$encoded_token` will contain a string representation of the encoded and encrypted token.

### Decoding the Token

To decode the token you'll need the string representation of the token, and the secret string you encoded it with:
```php
use Sergeymitr\SimpleJWT\Decoder;

$token = Decoder::do($encodedToken, 'secret');
```

The `Token` object provides a number of "getter" methods you can use to retrieve the values,
which you can [review](https://github.com/sergeymitr/simple-php-jwt/blob/master/src/TokenInterface.php) in the interface `TokenInterface`.
