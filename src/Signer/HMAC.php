<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT\Signer;

class HMAC implements SignerInterface
{

    protected static array $algoMap = [
        'HS256' => 'SHA256',
        'HS384' => 'SHA384',
        'HS512' => 'SHA512',
    ];

    private string $algo;

    /**
     * @param string $algo The token signing algorithm.
     * @throws Exception
     */
    public function __construct(string $algo)
    {
        $algo = strtoupper($algo);

        if (!array_key_exists($algo, static::$algoMap)) {
            throw new Exception("Unknown signing algorithm: '{$algo}'");
        }

        $this->algo = $algo;
    }

    public function sign(string $headerEncoded, string $payloadEncoded, string $secret): string
    {
        return hash_hmac(static::$algoMap[$this->algo], "{$headerEncoded}.{$payloadEncoded}", $secret, true);
    }

    public function getAlgo(): string
    {
        return $this->algo;
    }
}
