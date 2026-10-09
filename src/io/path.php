<?php

namespace Vosiz\Utils\Io;

class Path {

    const READ         = 0x04;
    const WRITE        = 0x02;
    const EXECUTE      = 0x01;
    const MODE_DEFAULT = 0755;


    /**
     * Combines path parts into single path (leading slash of the first part is kept)
     * @param string ...$parts
     * @return string
     */
    public static function Combine(...$parts) {

        $root = preg_match('~^[/\\\\]~', (string)reset($parts)) ? DIRECTORY_SEPARATOR : '';

        return $root . preg_replace(
            '~[/\\\\]+~',
            DIRECTORY_SEPARATOR,
            join(DIRECTORY_SEPARATOR, array_map(fn($p) => trim($p, "/\\"), $parts))
        );
    }

    /**
     * Sets owner permissions on file or directory
     * Group and others get read+execute by default
     * @param string $path
     * @param bool $read
     * @param bool $write
     * @param bool $execute
     * @param int $others Group and others bits (0 = owner only)
     * @return bool
     */
    public static function SetPermissions(string $path, bool $read = true, bool $write = true, bool $execute = true, int $others = 0055) {

        $owner = 0;
        if($read)    $owner |= self::READ;
        if($write)   $owner |= self::WRITE;
        if($execute) $owner |= self::EXECUTE;

        $mode = ($owner << 6) | ($others & 0077);
        return chmod($path, $mode);
    }

    /**
     * Returns path without file extension (dotfile has no extension)
     * @param string $path
     * @return string
     */
    public static function StripExt(string $path) {

        $path = rtrim($path, "/\\");
        $base = basename($path);
        $dot  = strrpos($base, '.');

        if($dot === false || $dot === 0)
            return $path;

        return substr($path, 0, strlen($path) - strlen($base) + $dot);
    }

}
