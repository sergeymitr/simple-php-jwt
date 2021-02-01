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
            'iat' => 1577836700,
            'jti' => 'sample-id',
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $token = Token::import($headerData, $payloadData);

        self::assertEquals($headerData, $token->getHeaders());
        self::assertEquals($payloadData, $token->getPayload());

        self::assertEquals($headerData['typ'], $token->getType());
        self::assertEquals($headerData['alg'], $token->getCustomHeader('alg'));
        self::assertEquals($headerData['h-key1'], $token->getCustomHeader('h-key1'));
        self::assertEquals($headerData['h-key2'], $token->getCustomHeader('h-key2'));

        self::assertEquals(DateTime::createFromFormat('U', (string)$payloadData['iat']), $token->getIssuedAt());
        self::assertEquals($payloadData['iss'], $token->getIssuer());
        self::assertEquals($payloadData['sub'], $token->getSubject());
        self::assertEquals($payloadData['aud'], $token->getAudience());
        self::assertEquals(DateTime::createFromFormat('U', (string)$payloadData['exp']), $token->getExpiration());
        self::assertEquals(DateTime::createFromFormat('U', (string)$payloadData['nbf']), $token->getNotBefore());
        self::assertEquals($payloadData['jti'], $token->getID());
        self::assertEquals($payloadData['key1'], $token->getCustomPayload('key1'));
        self::assertEquals($payloadData['key2'], $token->getCustomPayload('key2'));
    }
}
