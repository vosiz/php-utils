<?php

namespace Vosiz\Utils\Crypto;

class PasswordHasher {

    private $Salt;

    /**
     * Constructor
     * @param string $salt Pepper, mixed into every password before hashing
     */
    public function __construct(string $salt) {

        $this->Salt = $salt;
    }


    /**
     * Hash password
     * @param string $password Password string
     * @return string password_hash() output, length depends on algorithm (store as 255 chars)
     */
    public function Hash(string $password) {

        return password_hash($this->Pepper($password), PASSWORD_DEFAULT);
    }

    /**
     * Verfies password
     * @param string $password Password string
     * @param string $hashed Stored hashed string
     * @return bool true if equals
     */
    public function Verify(string $password, string $hashed) {

        return password_verify($this->Pepper($password), $hashed);
    }


    /**
     * Mixes pepper into password
     * @param string $password Password string
     * @return string 64 chars
     */
    private function Pepper(string $password) {

        return hash_hmac('sha256', $password, $this->Salt);
    }
}