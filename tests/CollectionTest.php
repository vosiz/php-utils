<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Collections\Collection;

class CollectionTest extends TestCase {

    /** @test */
    public function AddReturnsTrueForNewKey() {

        $c = new Collection();

        $this->assertTrue($c->Add(1, 'name'));
        $this->assertTrue($c->AddRange(['a' => 1, 'b' => 2]));
    }

    /** @test */
    public function KeyLookupsUseSameFormAsAdd() {

        $c = new Collection();
        $c->Add(1, 'my_key');

        $this->assertTrue($c->HasKey('my_key'));
        $this->assertTrue($c->HasKey('MyKey'));
        $this->assertSame(1, $c->my_key);
    }

    /** @test */
    public function IssetFollowsGet() {

        $c = new Collection(['name' => 'x']);

        $this->assertTrue(isset($c->name));
        $this->assertFalse(isset($c->nope));
    }

    /** @test */
    public function RemoveKeepsStringKeysAndRenumbersNumeric() {

        $c = new Collection(['a' => 1, 'b' => 2, 10, 20, 30]);

        $c->Remove('a');
        $c->Remove(1);

        $this->assertSame(['B' => 2, 0 => 10, 1 => 30], $c->ToArray());
    }

    /** @test */
    public function ValueLookupsAreStrict() {

        $c = new Collection([0, 'abc', '5']);

        $this->assertFalse($c->HasValue(null));
        $this->assertFalse($c->Contains(5));
        $this->assertFalse($c->IndexOf(5));
        $this->assertSame(2, $c->Find('5'));
    }

    /** @test */
    public function KeysAcceptsValuesAsArguments() {

        $c = new Collection(['x' => 'a', 'y' => 'b', 'z' => 'a']);

        $this->assertSame(['X', 'Z', 'Y'], array_values($c->Keys('a', 'b')));
        $this->assertSame(['Y'], array_values($c->Keys(['b'])));
        $this->assertSame(['X', 'Y', 'Z'], $c->Keys());
    }

    /** @test */
    public function IsCountable() {

        $this->assertCount(2, new Collection([1, 2]));
    }
}
