<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Collections\Collection;

class ObjectTest extends TestCase {

    /** @test */
    public function SingletonHoldsInstancePerSubclass() {

        $this->assertInstanceOf(ObjectTestFirst::class, ObjectTestFirst::GetInstance());
        $this->assertInstanceOf(ObjectTestSecond::class, ObjectTestSecond::GetInstance());
        $this->assertSame(ObjectTestFirst::GetInstance(), ObjectTestFirst::GetInstance());
    }

    /** @test */
    public function HashIsStablePerInstance() {

        $a = new Collection();
        $b = new Collection();

        $this->assertSame($a->GetHash(), $a->GetHash());
        $this->assertNotSame($a->GetHash(), $b->GetHash());
    }

    /** @test */
    public function EqualsComparesInstances() {

        $a = new Collection();

        $this->assertTrue($a->Equals($a));
        $this->assertFalse($a->Equals(new Collection()));
    }

    /** @test */
    public function ComparingWithForeignValueIsFalse() {

        $a = new Collection();

        $this->assertFalse($a->Equals('x'));
        $this->assertFalse($a->CompareType(5));
    }
}

class ObjectTestFirst extends Singleton {

}

class ObjectTestSecond extends Singleton {

}
