<?php

class Singleton extends SmartObject {

    static protected $Instance = NULL;

    /**
     * Construct
     */
    private function __construct() {

        parent::__construct();
    }


    /**
     * Getter for instance
     * @return Singleton
     */
    public static function GetInstance() {  

        if (self::$Instance === NULL) {

            $class_name = get_called_class();
            self::$Instance = new $class_name;
        }

        return self::$Instance;
    }
}