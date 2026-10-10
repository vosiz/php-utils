<?php

namespace Vosiz\Utils\Io;

class Dir {

    /**
     * Creates directory
     * @param string $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public static function Create(string $path, int $mode = Path::MODE_DEFAULT, bool $recursive = true) {

        if(is_dir($path))
            return true;

        // failed mkdir can still mean someone else created it meanwhile
        return mkdir($path, $mode, $recursive) || is_dir($path);
    }

    /**
     * Returns sorted list of files in directory, dotfiles are skipped
     * @param string $path
     * @param bool $recursive Include subdirectories
     * @param bool $with_ext Include extension in returned paths
     * @return array
     */
    public static function GetFiles(string $path, bool $recursive = false, bool $with_ext = true) {

        $path = rtrim($path, '/\\');
        $results = [];

        if(!is_dir($path))
            return $results;

        foreach(scandir($path) as $name) {

            if($name[0] === '.')
                continue;

            $entry = $path . '/' . $name;

            if(is_file($entry)) {

                $results[] = $with_ext ? $entry : Path::StripExt($entry);

            } elseif($recursive && is_dir($entry)) {

                $results = array_merge($results, self::GetFiles($entry, true, $with_ext));
            }
        }

        return $results;
    }

}
