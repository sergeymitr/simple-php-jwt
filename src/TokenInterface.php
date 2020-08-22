<?php

declare(strict_types=1);

namespace Sergeymitr\SimpleJWT;

use DateTimeInterface;

/**
 * The Token object interface.
 */
interface TokenInterface
{
    /**
     * Returns all defined fields (claims).
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Set the token issuer (e.g. your website name or URL).
     * Optional.
     *
     * @param  string  $issuer
     *
     * @return $this
     */
    public function setIssuer(string $issuer): TokenInterface;

    /**
     * Set the token subject (e.g. "auth").
     * Optional.
     *
     * @param  string  $subject
     *
     * @return $this
     */
    public function setSubject(string $subject): TokenInterface;

    /**
     * Set the token recipient (e.g. username or email).
     * If the recipient doesn't match, the token MUST BE rejected by the receiving application.
     * Optional.
     *
     * @param  string|array  $audience
     *
     * @return $this
     */
    public function setAudience($audience): TokenInterface;

    /**
     * Set the token expiration date/time.
     * The token MUST NOT BE accepted after the provided date/time.
     * Optional.
     *
     * @param  DateTimeInterface  $expiration
     *
     * @return $this
     */
    public function setExpiration(DateTimeInterface $expiration): TokenInterface;

    /**
     * Set the token "Not Before" claim.
     * The token MUST NOT BE accepted before the provided date/time.
     *
     * @param  DateTimeInterface  $notBefore
     *
     * @return $this
     */
    public function setNotBefore(DateTimeInterface $notBefore): TokenInterface;

    /**
     * Set the unique identification string for your token.
     * It's important for the string to be unique.
     * Optional.
     *
     * @param  string  $id
     *
     * @return $this
     */
    public function setID(string $id): TokenInterface;

    /**
     * Add a custom claim to the token.
     *
     * @param string $key The custom key.
     * @param string $value The claim value.
     * @return $this
     */
    public function setCustom(string $key, string $value): TokenInterface;
}
