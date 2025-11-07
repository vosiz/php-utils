<?php

namespace Vosiz\Utils\Crypto;

class PasswordHasher {

    private $Salt;

    /**
     * Constructor
     */
    public function __construct(string $salt) {

        $this->Salt = $salt;
    }


    /**
     * Hash password
     * @param string $password Password string
     * @return string 64 chars
     */
    public function Hash(string $password) {

        return hash('sha256', $this->Salt.$password);
    }

    /**
     * Verfies password
     * @param string $password Password string
     * @param string $hashed Stored hashed string
     * @return bool true if equals
     */
    public function Verify(string $password, string $hashed) {

        $hash = $this->hash($password);
        return hash_equals($hash, $hashed);
    }
}