<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT;

use DateTime;
use DateTimeInterface;

class Token implements TokenInterface
{
    private const DEFAULT_TOKEN_TYPE = 'JWT';

    private array $payload = array();

    private array $header = array();

    public static function import(array $headers, array $payload): TokenInterface
    {
        $headers = array_filter($headers, 'is_scalar');
        $payload = array_filter($payload, 'is_scalar');

        $token = new static();

        if (!empty($headers['typ'])) {
            $token->setType($headers['typ']);
            unset($headers['typ']);
        }

        array_walk($headers, function ($value, $key) use ($token) {
            $token->setCustomHeader($key, $value);
        });

        if (!empty($payload['iat'])) {
            $token->setIssuedAt(DateTime::createFromFormat('U', (string)$payload['iat']));
            unset($payload['iat']);
        }

        if (!empty($payload['iss'])) {
            $token->setIssuer($payload['iss']);
            unset($payload['iss']);
        }

        if (!empty($payload['sub'])) {
            $token->setSubject($payload['sub']);
            unset($payload['sub']);
        }

        if (!empty($payload['aud'])) {
            $token->setAudience($payload['aud']);
            unset($payload['aud']);
        }

        if (!empty($payload['exp'])) {
            $token->setExpiration(DateTime::createFromFormat('U', (string)$payload['exp']));
            unset($payload['exp']);
        }

        if (!empty($payload['nbf'])) {
            $token->setNotBefore(DateTime::createFromFormat('U', (string)$payload['nbf']));
            unset($payload['nbf']);
        }

        if (!empty($payload['jti'])) {
            $token->setID($payload['jti']);
            unset($payload['jti']);
        }

        array_walk($payload, function ($value, $key) use ($token) {
            $token->setCustomPayload($key, $value);
        });

        return $token;
    }

    public static function create(): TokenInterface
    {
        return (new static())
            ->setIssuedAt(new DateTime())
            ->setType(self::DEFAULT_TOKEN_TYPE);
    }

    public function getHeaders(): array
    {
        return $this->header;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * Set the "Issued At" claim.
     *
     * @param DateTimeInterface $dateTime
     * @return $this;
     */
    public function setIssuedAt(DateTimeInterface $dateTime): TokenInterface
    {
        $this->payload['iat'] = (int)$dateTime->format('U');
        return $this;
    }

    public function setIssuer(string $issuer): TokenInterface
    {
        $this->payload['iss'] = $issuer;
        return $this;
    }

    public function setSubject(string $subject): TokenInterface
    {
        $this->payload['sub'] = $subject;
        return $this;
    }

    public function setAudience($audience): TokenInterface
    {
        $this->payload['aud'] = $audience;
        return $this;
    }

    public function setExpiration(DateTimeInterface $expiration): TokenInterface
    {
        $this->payload['exp'] = (int)$expiration->format('U');
        return $this;
    }

    public function setNotBefore(DateTimeInterface $notBefore): TokenInterface
    {
        $this->payload['nbf'] = (int)$notBefore->format('U');
        return $this;
    }

    public function setID(string $id): TokenInterface
    {
        $this->payload['jti'] = $id;
        return $this;
    }

    public function setCustomPayload(string $key, string $value): TokenInterface
    {
        $this->payload[$key] = $value;
        return $this;
    }

    public function setType(string $value): TokenInterface
    {
        $this->header['typ'] = $value;
        return $this;
    }

    public function setCustomHeader(string $key, string $value): TokenInterface
    {
        $this->header[$key] = $value;
        return $this;
    }

    public function getType(): ?string
    {
        return empty($this->header['typ']) ? null : (string)$this->header['typ'];
    }

    public function getIssuer(): ?string
    {
        return empty($this->payload['iss']) ? null : (string)$this->payload['iss'];
    }

    public function getSubject(): ?string
    {
        return empty($this->payload['sub']) ? null : (string)$this->payload['sub'];
    }

    public function getAudience(): ?string
    {
        return empty($this->payload['aud']) ? null : (string)$this->payload['aud'];
    }

    public function getExpiration(): ?DateTimeInterface
    {
        return empty($this->payload['exp'])
            ? null
            : DateTime::createFromFormat('U', (string)$this->payload['exp']);
    }

    public function getNotBefore(): ?DateTimeInterface
    {
        return empty($this->payload['nbf'])
            ? null
            : DateTime::createFromFormat('U', (string)$this->payload['nbf']);
    }

    public function getID(): ?string
    {
        return empty($this->payload['jti']) ? null : (string)$this->payload['jti'];
    }

    public function getCustomPayload(string $key): ?string
    {
        return empty($this->payload[$key]) ? null : (string)$this->payload[$key];
    }

    public function getCustomHeader(string $key): ?string
    {
        return empty($this->header[$key]) ? null : (string)$this->header[$key];
    }
}
