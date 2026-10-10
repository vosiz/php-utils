<?php

use PHPUnit\Framework\TestCase;

class ExceptionfTest extends TestCase {

    /** @test */
    public function PercentWithoutArgumentsIsPlainText() {

        $exc = new Exceptionf('LIKE %abc% at 100%');

        $this->assertSame('LIKE %abc% at 100%', $exc->getMessage());
    }

    /** @test */
    public function FormatWithArgumentsStillFormats() {

        $this->assertSame('a 5 b', (new Exceptionf('a %d b', 5))->getMessage());
    }

    /** @test */
    public function UnimplementedStateWithPercent() {

        $this->assertSame('Unimplemented state 50%', (new UnimplementedStateException('50%'))->getMessage());
    }

    /** @test */
    public function ToStringPrintsWholeInnerChain() {

        $mid = new Exceptionf('mid');
        $mid->SetInner(new Exceptionf('deep'));
        $top = new Exceptionf('top');
        $top->SetInner($mid);

        $this->assertSame('[EXCf]: top'.PHP_EOL.'- mid'.PHP_EOL.'  - deep', $top->ToString());
    }

    /** @test */
    public function ForeignInnerKeepsTypeAndInstance() {

        $foreign = new RuntimeException('boom');
        $exc     = Exceptionf::CreateInner($foreign, 'wrap');

        $this->assertSame('[EXCf]: wrap'.PHP_EOL.'- RuntimeException: boom', $exc->ToString());
        $this->assertSame($foreign, $exc->GetInner());
    }

    /** @test */
    public function AsStringRecognisesSubclass() {

        $this->assertSame('[EXCf]: Unimplemented state x', Exceptionf::AsString(new UnimplementedStateException('x')));
    }
}
