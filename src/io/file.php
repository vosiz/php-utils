<?php

namespace Vosiz\Utils\Io;

class File {

    /**
     * Returns absolute path if file exists, false otherwise
     * @param string $path
     * @return string|false
     */
    public static function Exists(string $path) {

        $real = realpath($path);
        return ($real !== false && is_file($real)) ? $real : false;
    }

    /**
     * Creates an empty file, existing file is truncated
     * @param string $path
     * @return bool
     */
    public static function Create(string $path) {

        return file_put_contents($path, '') !== false;
    }

    /**
     * Appends text to file
     * @param string $path
     * @param string $text
     * @param bool $new_line Append newline after text
     * @return bool
     */
    public static function Append(string $path, string $text, bool $new_line = false) {

        return file_put_contents($path, $text . ($new_line ? PHP_EOL : ''), FILE_APPEND) !== false;
    }

}
