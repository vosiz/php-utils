<?php

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase {

    /** @test */
    public function AsArrayTakesExpression() {

        $this->assertSame(['x'], asarray('x'));
        $this->assertSame([1, 2], asarray([1, 2]));
    }

    /** @test */
    public function SnakeKeepsAcronymAsOneWord() {

        $this->assertSame('user_id', str_snake('UserID'));
        $this->assertSame('http_request', str_snake('HTTPRequest'));
        $this->assertSame('my_key', str_snake('MyKey'));
        $this->assertSame('user_name', snake('userName'));
    }

    /** @test */
    public function UnsetraRenumbersOnlyNumericKeys() {

        $list = [10, 20, 30];
        unsetra($list, 0);

        $mixed = ['a' => 1, 5, 6];
        unsetra($mixed, 0);

        $this->assertSame([20, 30], $list);
        $this->assertSame(['a' => 1, 0 => 6], $mixed);
    }

    /** @test */
    public function InstclassThrowsOnMissingClass() {

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Class 'Nope' not defined.");

        instclass('Nope');
    }

    /** @test */
    public function Int2bNegativeIsTrue() {

        $this->assertTrue(int2b(-1));
        $this->assertTrue(int2b(1));
        $this->assertFalse(int2b(0));
    }

    /** @test */
    public function TostrObjectWithoutToArrayFallsBackToType() {

        $this->assertSame('FunctionsTestPlain', tostr(new FunctionsTestPlain(), true));
    }

    /** @test */
    public function ConvertExceptionKeepsPercentInContent() {

        $exc = new ConvertException('50%', '100% wrong');

        $this->assertSame('Convert failed for VAR: 50%; 100% wrong', $exc->getMessage());
    }

    /** @test */
    public function ClassesFromFilesListAreLoaded() {

        $this->assertTrue(class_exists('Guid', false));
        $this->assertTrue(class_exists('KeyValuePairStrict', false));
        $this->assertTrue(interface_exists('IToString', false));
        $this->assertTrue(interface_exists('IComparable', false));
    }
}

class FunctionsTestPlain {

}
