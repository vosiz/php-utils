<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Crypto\PasswordHasher;

class PasswordHasherTest extends TestCase {

    /** @test */
    public function VerifiesOwnHash() {

        $hasher = new PasswordHasher('pepper');
        $hash   = $hasher->Hash('secret');

        $this->assertTrue($hasher->Verify('secret', $hash));
        $this->assertFalse($hasher->Verify('Secret', $hash));
    }

    /** @test */
    public function SamePasswordHashesDifferently() {

        $hasher = new PasswordHasher('pepper');

        $this->assertNotSame($hasher->Hash('secret'), $hasher->Hash('secret'));
    }

    /** @test */
    public function PepperIsPartOfTheHash() {

        $hash = (new PasswordHasher('pepper'))->Hash('secret');

        $this->assertFalse((new PasswordHasher('other'))->Verify('secret', $hash));
    }
}
