<?php

namespace Vosiz\Utils\Io;

class Dir {

    /**
     * Creates directory
     * @param string $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     * @throws \Exception
     */
    public static function Create(string $path, int $mode = Path::MODE_DEFAULT, bool $recursive = true) {

        if(is_dir($path))
            return true;

        try {

            return mkdir($path, $mode, $recursive);

        } catch(\Exception $exc) {

            throw new \Exception("Cannot create directory '$path': " . $exc->getMessage());
        }
    }

    /**
     * Returns list of files in directory
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

        if($recursive) {

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
            );
            foreach($iterator as $file) {

                if($file->isFile())
                    $results[] = $with_ext ? $file->getRealPath() : Path::StripExt($file->getRealPath());
            }

        } else {

            foreach(glob($path . '/*') as $entry) {

                if(is_file($entry))
                    $results[] = $with_ext ? $entry : Path::StripExt($entry);
            }
        }

        return $results;
    }

}
