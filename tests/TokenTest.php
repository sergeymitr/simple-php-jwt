<?php

namespace Sergeymitr\SimpleJWT\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Sergeymitr\SimpleJWT\Token;

class TokenTest extends TestCase
{
    public function testCreate(): void
    {
        $claimsData = [
            'issuer' => 'Sergeymitr\SimpleJWT',
            'subject' => 'Test Sample',
            'audience' => 'PHPUnit',
            'expiration' => new DateTime('2020-02-02'),
            'notBefore' => new DateTime('2020-01-01'),
            'ID' => 'sample-id'
        ];

        $startTime = time();
        $token = Token::create();

        foreach ($claimsData as $key => $data) {
            $token->{'set' . strtoupper($key)}($data);
        }

        $token->setCustomHeader('h-key1', 'h-value1');
        $token->setCustomHeader('h-key2', 'h-value2');

        $token->setCustomPayload('key1', 'value1');
        $token->setCustomPayload('key2', 'value2');

        $tokenPayload = $token->getPayload();

        self::assertEquals($claimsData['issuer'], $tokenPayload['iss']);
        self::assertEquals($claimsData['subject'], $tokenPayload['sub']);
        self::assertEquals($claimsData['audience'], $tokenPayload['aud']);
        self::assertEquals($claimsData['expiration']->format('U'), $tokenPayload['exp']);
        self::assertEquals($claimsData['notBefore']->format('U'), $tokenPayload['nbf']);
        self::assertEquals($claimsData['ID'], $tokenPayload['jti']);
        self::assertGreaterThanOrEqual($startTime, $tokenPayload['iat']);

        self::assertEquals('value1', $tokenPayload['key1']);
        self::assertEquals('value2', $tokenPayload['key2']);

        $tokenHeaders = $token->getHeaders();

        self::assertEquals('JWT', $tokenHeaders['typ']);
        self::assertEquals('h-value1', $tokenHeaders['h-key1']);
        self::assertEquals('h-value2', $tokenHeaders['h-key2']);
    }

    public function testImport()
    {
        $headerData = [
            'typ' => 'JWT',
            'alg' => 'HS256',
            'h-key1' => 'h-value1',
            'h-key2' => 'h-value2'
        ];

        $payloadData = [
            'iss' => 'Sergeymitr\SimpleJWT',
            'sub' => 'Test Sample',
            'aud' => 'PHPUnit',
            'exp' => 1580601600,
            'nbf' => 1577836800,
            'jti' => 'sample-id',
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $token = Token::import($headerData, $payloadData);

        self::assertEquals($headerData, $token->getHeaders());
        self::assertEquals($payloadData, $token->getPayload());
    }
}
