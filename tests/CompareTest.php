<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Collections\Collection;

class CompareTest extends TestCase {

    /** @test */
    public function NullOrEmptyForEmptyValues() {

        $this->assertTrue(is_noe(null));
        $this->assertTrue(is_noe(''));
        $this->assertTrue(is_noe([]));
        $this->assertTrue(is_noe(new Collection()));
    }

    /** @test */
    public function NullOrEmptyKeepsZeroAndFalseAsValues() {

        $this->assertFalse(is_noe(0));
        $this->assertFalse(is_noe('0'));
        $this->assertFalse(is_noe(false));
        $this->assertFalse(is_noe(new Collection([1])));
    }

    /** @test */
    public function TypeOfMatchesParentClassAndInterface() {

        $this->assertTrue(is_typeof(new UnimplementedStateException('x'), 'Exceptionf'));
        $this->assertTrue(is_typeof(new Collection(), 'Countable'));
    }

    /** @test */
    public function TypeOfComparesPrimitivesByName() {

        $this->assertTrue(is_typeof(5, 'integer'));
        $this->assertFalse(is_typeof(5, 'string'));
    }
}
