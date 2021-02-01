<?php

namespace Sergeymitr\SimpleJWT\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Sergeymitr\SimpleJWT\Decoder;

class DecoderTest extends TestCase
{
    /**
     * @dataProvider decodeDataProvider
     *
     * @param string $token The token string itself.
     * @param string $secret The secret to decode the token.
     * @param array $data Expected token data to compare.
     */
    public function testDecodeValid(string $token, string $secret, array $data)
    {
        $token = Decoder::do($token, $secret);

        self::assertEquals($data['payload']['iat'], $token->getIssuedAt());
        self::assertEquals($data['payload']['iss'], $token->getIssuer());
        self::assertEquals($data['payload']['sub'], $token->getSubject());
        self::assertEquals($data['payload']['aud'], $token->getAudience());
        self::assertEquals($data['payload']['exp'], $token->getExpiration());
        self::assertEquals($data['payload']['nbf'], $token->getNotBefore());
        self::assertEquals($data['payload']['jti'], $token->getID());

        self::assertEquals($data['header']['typ'], $token->getType());
        self::assertEquals($data['header']['alg'], $token->getCustomHeader('alg'));
    }

    public function decodeDataProvider(): array
    {
        return [
            [
                'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NzkwNDY0MDAsImlzcyI6IlNlcmdleW1pdHJcXFNpbXBsZUpXVCIsInN1YiI6IlRlc3QgU2FtcGxlIiwiYXVkIjoiUEhQVW5pdCIsImV4cCI6MTU4MDYwMTYwMCwibmJmIjoxNTc3ODM2ODAwLCJqdGkiOiJzYW1wbGUtaWQifQ.GPEZeJIXDdkQ0rhtAP-KePv_1ABWHA6WiyaaUEQAdFs',
                'something-secret',
                [
                    'payload' => [
                        'iat' => DateTime::createFromFormat('U', '1579046400'),
                        'iss' => 'Sergeymitr\SimpleJWT',
                        'sub' => 'Test Sample',
                        'aud' => 'PHPUnit',
                        'exp' => DateTime::createFromFormat('U', '1580601600'),
                        'nbf' => DateTime::createFromFormat('U', '1577836800'),
                        'jti' => 'sample-id'
                    ],
                    'header' => [
                        'typ' => 'JWT',
                        'alg' => 'HS256'
                    ]
                ]
            ]
        ];
    }
}
