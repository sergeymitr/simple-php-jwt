<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT;

use Sergeymitr\SimpleJWT\Signer\HMAC;
use Sergeymitr\SimpleJWT\Signer\SignerInterface;

class Encoder
{
    /**
     * Token payload.
     */
    private array $payload;

    /**
     * Token header data.
     */
    private array $headers;

    /**
     * The signer object.
     *
     * @var SignerInterface
     */
    private SignerInterface $signer;

    /**
     * Encode the token, sign it, and return a string
     *
     * @param TokenInterface $token The token to encode.
     * @param string $secret The secret key to sign the token.
     * @param SignerInterface|null $signer The Token Signer object.
     * @return string
     */
    public static function do(TokenInterface $token, string $secret, SignerInterface $signer = null): string
    {
        if (null === $signer) {
            $signer = new HMAC('HS256');
        }

        $encoder = new static($token->getHeaders(), $token->getPayload(), $signer);
        return $encoder->encode($secret);
    }

    /**
     * @param array $payload Token payload.
     * @param SignerInterface $signer The Token Signer object.
     */
    public function __construct(array $headers, array $payload, SignerInterface $signer)
    {
        $this->headers = $headers;
        $this->payload = $payload;
        $this->signer = $signer;
    }

    /**
     * @param string $secret The secret key to sign the token.
     *
     * @return string
     */
    public function encode(string $secret): string
    {
        $headerEncoded = Tools::base64EncodeUrl(json_encode($this->getHeader()));
        $payloadEncoded = Tools::base64EncodeUrl(json_encode($this->getPayload()));
        $signature = Tools::base64EncodeUrl($this->signer->sign($headerEncoded, $payloadEncoded, $secret));

        return "{$headerEncoded}.{$payloadEncoded}.{$signature}";
    }

    private function getHeader(): array
    {
        $headers = $this->headers;

        $headers['alg'] = $this->signer->getAlgo();

        return $headers;
    }

    private function getPayload(): array
    {
        return $this->payload;
    }
}
