<?php

namespace Src\Security;

use Firebase\JWT\JWT;
use Exception;

class AccessHandler
{
    const ALGORITHMS = ["HS256"];

    /**
     * @var string
     */
    private string $secret;

    /**
     * Create a new access instance.
     *
     * @param  string $secret
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Checking read access.
     *
     * @param  string $token
     * @return bool
     */
    public function hasReadAccess(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, $this->secret, self::ALGORITHMS);
        } catch (Exception $e) {
            return false;
        }

        return isset($decoded->read) && $decoded->read;
    }

    /**
     * Checking read and write access.
     *
     * @param  string $token
     * @return bool
     */
    public function hasReadAndWriteAccess(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, $this->secret, self::ALGORITHMS);
        } catch (Exception $e) {
            return false;
        }

        return isset($decoded->read) && $decoded->read && isset($decoded->write) && $decoded->write;
    }

    /**
     * Generate Read Token.
     *
     * @return string
     */
    public function generateReadToken(): string
    {
        $token = [
            "read" => true,
            "write" => false,
            "exp" => time() + (60 * 60)
        ];

        return JWT::encode($token, $this->secret);
    }

    /**
     * Generate Read And Write Token.
     *
     * @return string
     */
    public function generateReadAndWriteToken(): string
    {
        $token = [
            "read" => true,
            "write" => true,
            "exp" => time() + (60 * 60)
        ];

        return JWT::encode($token, $this->secret);
    }
}
