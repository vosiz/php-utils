<?php

namespace Vosiz\Utils\Io;

class Inc {

    const METHOD_DEFAULT = 'require_once';


    /**
     * Includes all PHP files in directory
     * @param string $path Directory path
     * @param bool $recursive Include subdirectories
     * @param string $method require_once|require|include|include_once
     */
    public static function Dir(string $path, bool $recursive = false, string $method = self::METHOD_DEFAULT) {

        foreach(Dir::GetFiles($path, $recursive) as $file) {

            if(pathinfo($file, PATHINFO_EXTENSION) === 'php')
                self::Load($file, $method);
        }
    }

    /**
     * Includes list of files at given base path
     * @param string $path Base directory
     * @param array $files File names without extension
     * @param string $method require_once|require|include|include_once
     */
    public static function Files(string $path, array $files, string $method = self::METHOD_DEFAULT) {

        $path = rtrim($path, '/\\');
        foreach($files as $file) {

            self::Load(sprintf('%s/%s.php', $path, $file), $method);
        }
    }


    /**
     * Loads file using specified include method
     * @param string $filepath
     * @param string $method
     */
    private static function Load(string $filepath, string $method) {

        switch($method) {

            case 'require':      require($filepath);       break;
            case 'include':      include($filepath);       break;
            case 'include_once': include_once($filepath);  break;
            default:             require_once($filepath);  break;
        }
    }

}
