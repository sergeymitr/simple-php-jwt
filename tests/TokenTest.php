<?php

namespace Sergeymitr\SimpleJWT\Tests;

use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use Sergeymitr\SimpleJWT\Token;

class TokenTest extends TestCase
{
    private static array $claimsData = [];


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$claimsData = [
            'issuer' => 'Sergeymitr\SimpleJWT',
            'subject' => 'Test Sample',
            'audience' => 'PHPUnit',
            'expiration' => (new DateTime())->add(new DateInterval('P1D')),
            'notBefore' => (new DateTime())->add(new DateInterval('PT1M')),
            'ID' => 'sample-id'
        ];
    }

    public function testClaims(): void
    {
        $startTime = time();
        $token = new Token();

        foreach(self::$claimsData as $key => $data) {
            $token->{'set' . strtoupper($key)}($data);
        }

        $token->setCustom('key1', 'value1');
        $token->setCustom('key2', 'value2');

        $tokenClaims = $token->getAll();

        self::assertEquals(self::$claimsData['issuer'], $tokenClaims['iss']);
        self::assertEquals(self::$claimsData['subject'], $tokenClaims['sub']);
        self::assertEquals(self::$claimsData['audience'], $tokenClaims['aud']);
        self::assertEquals(self::$claimsData['expiration']->format('U'), $tokenClaims['exp']);
        self::assertEquals(self::$claimsData['notBefore']->format('U'), $tokenClaims['nbf']);
        self::assertEquals(self::$claimsData['ID'], $tokenClaims['jti']);
        self::assertGreaterThanOrEqual($startTime, $tokenClaims['iat']);

        self::assertEquals('value1', $tokenClaims['key1']);
        self::assertEquals('value2', $tokenClaims['key2']);
    }
}
