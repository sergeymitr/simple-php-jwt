<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT\Signer;

interface SignerInterface
{

    /**
     * @param string $algo The algorithm used to sign
     */
    public function __construct(string $algo);

    /**
     * @param string $headerEncoded Base64-encoded header.
     * @param string $payloadEncoded Base64-encoded payload.
     * @param string $secret The string to sign the token with (a secret string or an RSA private key).
     * @return string
     */
    public function sign(string $headerEncoded, string $payloadEncoded, string $secret): string;

    /**
     * Get the algorithm label.
     *
     * @return string
     */
    public function getAlgo(): string;
}
