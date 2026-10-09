<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\TimeFormat;

class TimeFormatTest extends TestCase {

    /** @test */
    public function MicrosecondsFollowSeconds() {

        $this->assertMatchesRegularExpression('/^\d{4}-\d\d-\d\d \d\d:\d\d:\d\d\.\d{6}$/', TimeFormat::Create());
        $this->assertMatchesRegularExpression('/^\d\d:\d\d:\d\d\.\d{3}$/', TimeFormat::Create('H:i:s', 3));
    }

    /** @test */
    public function DateOnlyFormatHasNoMicroseconds() {

        $this->assertMatchesRegularExpression('/^\d{4}-\d\d-\d\d$/', TimeFormat::Create('Y-m-d'));
    }
}
