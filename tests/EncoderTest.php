<?php

namespace Sergeymitr\SimpleJWT\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Sergeymitr\SimpleJWT\Encoder;
use Sergeymitr\SimpleJWT\Token;

class EncoderTest extends TestCase
{
    const TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NzkwNDY0MDAsImlzcyI6IlNlcmdleW1pdHJcXFNpbXBsZUpXVCIsInN1YiI6IlRlc3QgU2FtcGxlIiwiYXVkIjoiUEhQVW5pdCIsImV4cCI6MTU4MDYwMTYwMCwibmJmIjoxNTc3ODM2ODAwLCJqdGkiOiJzYW1wbGUtaWQifQ.GPEZeJIXDdkQ0rhtAP-KePv_1ABWHA6WiyaaUEQAdFs';
    const SECRET = 'something-secret';

    public function testEncode()
    {
        $token = Token::create()
            ->setIssuer('Sergeymitr\SimpleJWT')
            ->setSubject('Test Sample')
            ->setAudience('PHPUnit')
            ->setExpiration(new DateTime('2020-02-02'))
            ->setNotBefore(new DateTime('2020-01-01'))
            ->setIssuedAt(new DateTime('2020-01-15'))
            ->setID('sample-id');

        self::assertEquals(
            static::TOKEN,
            Encoder::do($token, static::SECRET)
        );
    }
}
