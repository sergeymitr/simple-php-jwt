<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT;

use DateTime;
use DateTimeInterface;

class Token implements TokenInterface
{

    private array $data = array();

    public function __construct()
    {
        $this->setIssuedAt(new DateTime());
    }

    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * Set the "Issued At" claim.
     *
     * @param  DateTimeInterface  $dateTime
     * @return $this;
     */
    private function setIssuedAt(DateTimeInterface $dateTime): TokenInterface
    {
        $this->data['iat'] = (int) $dateTime->format('U');
        return $this;
    }

    public function setIssuer(string $issuer): TokenInterface
    {
        $this->data['iss'] = $issuer;
        return $this;
    }

    public function setSubject(string $subject): TokenInterface
    {
        $this->data['sub'] = $subject;
        return $this;
    }

    public function setAudience($audience): TokenInterface
    {
        $this->data['aud'] = $audience;
        return $this;
    }

    public function setExpiration(DateTimeInterface $expiration): TokenInterface
    {
        $this->data['exp'] = (int)$expiration->format('U');
        return $this;
    }

    public function setNotBefore(DateTimeInterface $notBefore): TokenInterface
    {
        $this->data['nbf'] = (int)$notBefore->format('U');
        return $this;
    }

    public function setID(string $id): TokenInterface
    {
        $this->data['jti'] = $id;
        return $this;
    }

    public function setCustom(string $key, string $value): TokenInterface
    {
        $this->data[$key] = $value;
        return $this;
    }
}
