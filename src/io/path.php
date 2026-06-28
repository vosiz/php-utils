<?php

namespace Vosiz\Utils\Io;

class Path {

    const READ         = 0x04;
    const WRITE        = 0x02;
    const EXECUTE      = 0x01;
    const MODE_DEFAULT = 0755;


    /**
     * Combines path parts into single path
     * @param string ...$parts
     * @return string
     */
    public static function Combine(...$parts) {

        return preg_replace(
            '~[/\\\\]+~',
            DIRECTORY_SEPARATOR,
            join(DIRECTORY_SEPARATOR, array_map(fn($p) => trim($p, "/\\"), $parts))
        );
    }

    /**
     * Sets owner permissions on file or directory
     * Group and others get standard read+execute
     * @param string $path
     * @param bool $read
     * @param bool $write
     * @param bool $execute
     * @return bool
     */
    public static function SetPermissions(string $path, bool $read = true, bool $write = true, bool $execute = true) {

        $owner = 0;
        if($read)    $owner |= self::READ;
        if($write)   $owner |= self::WRITE;
        if($execute) $owner |= self::EXECUTE;

        $mode = ($owner << 6) | 0055;
        return chmod($path, $mode);
    }

    /**
     * Returns path without file extension
     * @param string $path
     * @return string
     */
    public static function StripExt(string $path) {

        return pathinfo($path, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($path, PATHINFO_FILENAME);
    }

}
