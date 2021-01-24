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
     * Create a new token object from scratch, auto-filling some required data.
     *
     * @return TokenInterface
     */
    public static function create(): TokenInterface;

    /**
     * Create a token object using existing headers and payload.
     *
     * @param array $headers Token headers.
     * @param array $payload Token payload.
     * @return TokenInterface
     */
    public static function import(array $headers, array $payload): TokenInterface;

    /**
     * Returns all header fields.
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Returns all payload fields (claims).
     *
     * @return array
     */
    public function getPayload(): array;

    /**
     * Set the token type (usually `JWT`).
     *
     * @param string $value
     * @return TokenInterface
     */
    public function setType(string $value): TokenInterface;

    /**
     * Get the token type.
     *
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * Set the "Issued At" claim.
     *
     * @param  DateTimeInterface  $dateTime
     * @return $this;
     */
    public function setIssuedAt(DateTimeInterface $dateTime): TokenInterface;

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
     * Get the token issuer.
     * Optional.
     *
     * @return string|null
     */
    public function getIssuer(): ?string;

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
     * Get the token subject.
     * Optional.
     *
     * @return string|null
     */
    public function getSubject(): ?string;

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
     * Get the token recipient (e.g. username or email).
     * If the recipient doesn't match, the token MUST BE rejected by the receiving application.
     * Optional.
     *
     * @return string|null
     */
    public function getAudience(): ?string;

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
     * Set the token expiration date/time.
     * The token MUST NOT BE accepted after the provided date/time.
     * Optional.
     *
     * @return DateTimeInterface|null
     */
    public function getExpiration(): ?DateTimeInterface;

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
     * Get the token "Not Before" claim.
     * The token MUST NOT BE accepted before the provided date/time.
     *
     * @return DateTimeInterface|null
     */
    public function getNotBefore(): ?DateTimeInterface;

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
     * Get the unique identification string for your token.
     * Optional.
     *
     * @return string|null
     */
    public function getID(): ?string;

    /**
     * Add a custom payload claim to the token.
     *
     * @param string $key The custom key.
     * @param string $value The claim value.
     * @return $this
     */
    public function setCustomPayload(string $key, string $value): TokenInterface;

    /**
     * Get a custom payload claim.
     *
     * @param string $key The custom key.
     *
     * @return string|null
     */
    public function getCustomPayload(string $key): ?string;

    /**
     * Add a custom header data to the token.
     *
     * @param string $key The custom key.
     * @param string $value The value.
     * @return $this
     */
    public function setCustomHeader(string $key, string $value): TokenInterface;

    /**
     * Get a custom header data.
     *
     * @param string $key The custom key.
     * @return string|null
     */
    public function getCustomHeader(string $key): ?string;
}
