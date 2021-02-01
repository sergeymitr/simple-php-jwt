<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT;

use Sergeymitr\SimpleJWT\Signer\HMAC;

class Decoder
{
    private string $token;

    public static function do(string $token, string $secret): TokenInterface
    {
        $decoder = new static($token);
        return $decoder->decode($secret);
    }

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function decode(string $secret): TokenInterface
    {
        $tokenData = array_filter(explode('.', $this->token));
        if (3 !== count($tokenData)) {
            throw new Exception('Invalid token format');
        }

        list($header, $payload, $signature) = array_map([Tools::class, 'base64DecodeUrl'], $tokenData);
        $header = json_decode($header);
        $payload = json_decode($payload);

        if (!$header) {
            throw new Exception('Invalid token header');
        }

        if (!$payload) {
            throw new Exception('Invalid token payload');
        }

        if (!$signature) {
            throw new Exception('Invalid token signature');
        }

        if (empty($header->alg)) {
            throw new Exception('Invalid signing algorithm');
        }

        if (empty($header->typ) || 'JWT' !== $header->typ) {
            throw new Exception('Invalid token type');
        }

        $newSignature = (new HMAC($header->alg))->sign($tokenData[0], $tokenData[1], $secret);
        if (!$newSignature || 0 !== strcmp($signature, $newSignature)) {
            throw new Exception('Invalid secret');
        }

        return Token::import((array)$header, (array)$payload);
    }
}
