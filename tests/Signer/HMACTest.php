<?php

namespace Sergeymitr\SimpleJWT\Tests\Signer;

use PHPUnit\Framework\TestCase;
use Sergeymitr\SimpleJWT\Signer\Exception as SignerException;
use Sergeymitr\SimpleJWT\Signer\HMAC as SignerHMAC;

class HMACTest extends TestCase
{

    private static array $header = [
        'typ' => 'JWT'
    ];

    private static array $payload = [
        'key1' => 'value1',
        'key2' => 'value2'
    ];

    private static string $secret = 'hello-world';

    /**
     * @param string $algoLabel
     * @param string $algoKey
     * @throws SignerException
     * @dataProvider algorithmsDataProvider
     */
    public function testSign(string $algoLabel, string $algoKey): void
    {
        $header = base64_encode(json_encode(static::$header + array('alg' => $algoLabel)));
        $payload = base64_encode(json_encode(static::$payload));

        $signedToken = (new SignerHMAC($algoLabel))->sign($header, $payload, static::$secret);

        $signedOriginal = hash_hmac($algoKey, "{$header}.{$payload}", static::$secret, true);

        static::assertEquals($signedToken, $signedOriginal);
    }

    public function testSignInvalid(): void
    {
        $this->expectException(SignerException::class);
        new SignerHMAC('invalid');
    }

    public function algorithmsDataProvider()
    {
        return [
            ['HS256', 'SHA256'],
            ['HS384', 'SHA384'],
            ['HS512', 'SHA512']
        ];
    }

}
