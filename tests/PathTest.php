<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Io;

class PathTest extends TestCase {

    private $Dir;

    protected function setUp(): void {

        $this->Dir = sys_get_temp_dir().'/php_utils_'.uniqid();
        mkdir($this->Dir);
    }

    protected function tearDown(): void {

        array_map('unlink', glob($this->Dir.'/*'));
        rmdir($this->Dir);
    }

    /** @test */
    public function CombineKeepsLeadingSlash() {

        $this->assertSame('/var/www/x/y.php', Io\Path::Combine('/var/www', 'x', 'y.php'));
    }

    /** @test */
    public function CombineRelativeStaysRelative() {

        $this->assertSame('var/www/x', Io\Path::Combine('var/www/', '/x'));
    }

    /** @test */
    public function StripExtWithoutDirectory() {

        $this->assertSame('file', Io\Path::StripExt('file.txt'));
    }

    /** @test */
    public function StripExtDotfileHasNoExtension() {

        $this->assertSame('/a/.htaccess', Io\Path::StripExt('/a/.htaccess'));
    }

    /** @test */
    public function StripExtRemovesOnlyLastExtension() {

        $this->assertSame('/a/b.c/file.tar', Io\Path::StripExt('/a/b.c/file.tar.gz'));
        $this->assertSame('/a/b.c/file', Io\Path::StripExt('/a/b.c/file'));
    }

    /** @test */
    public function SetPermissionsDefaultGivesOthersReadExecute() {

        $file = $this->Dir.'/a.txt';
        touch($file);

        Io\Path::SetPermissions($file);

        $this->assertSame('755', $this->Mode($file));
    }

    /** @test */
    public function SetPermissionsOthersCanBeTurnedOff() {

        $file = $this->Dir.'/a.txt';
        touch($file);

        Io\Path::SetPermissions($file, true, true, false, 0);

        $this->assertSame('600', $this->Mode($file));
    }


    private function Mode(string $path) {

        clearstatcache();
        return substr(sprintf('%o', fileperms($path)), -3);
    }
}
