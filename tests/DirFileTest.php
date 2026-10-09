<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Io;

class DirFileTest extends TestCase {

    private $Dir;

    protected function setUp(): void {

        $this->Dir = sys_get_temp_dir().'/php_utils_'.uniqid();

        mkdir($this->Dir.'/sub[1]', 0755, true);
        foreach(['b.php', 'a.php', '.hidden', 'sub[1]/c.php'] as $file)
            touch($this->Dir.'/'.$file);
    }

    protected function tearDown(): void {

        foreach(['b.php', 'a.php', '.hidden', 'sub[1]/c.php'] as $file)
            unlink($this->Dir.'/'.$file);

        rmdir($this->Dir.'/sub[1]');
        rmdir($this->Dir);
    }

    /** @test */
    public function GetFilesFlatIsSortedAndSkipsDotfiles() {

        $this->assertSame([$this->Dir.'/a.php', $this->Dir.'/b.php'], Io\Dir::GetFiles($this->Dir));
    }

    /** @test */
    public function GetFilesRecursiveKeepsGivenPathForm() {

        $expected = [$this->Dir.'/a.php', $this->Dir.'/b.php', $this->Dir.'/sub[1]/c.php'];

        $this->assertSame($expected, Io\Dir::GetFiles($this->Dir.'/', true));
    }

    /** @test */
    public function GetFilesWorksWithGlobCharactersInPath() {

        $this->assertSame([$this->Dir.'/sub[1]/c'], Io\Dir::GetFiles($this->Dir.'/sub[1]', false, false));
    }

    /** @test */
    public function GetFilesOfMissingDirectoryIsEmpty() {

        $this->assertSame([], Io\Dir::GetFiles($this->Dir.'/nope'));
    }

    /** @test */
    public function DirCreateOnExistingDirectoryIsTrue() {

        $this->assertTrue(Io\Dir::Create($this->Dir.'/sub[1]'));
    }

    /** @test */
    public function FileCreateTruncatesExistingFile() {

        $file = $this->Dir.'/a.php';
        file_put_contents($file, 'content');

        $this->assertTrue(Io\File::Create($file));
        $this->assertSame('', file_get_contents($file));
    }
}
