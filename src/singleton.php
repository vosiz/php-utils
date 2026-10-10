<?php

class Singleton extends SmartObject {

    static protected $Instance = NULL; // unused, kept for subclasses that still read it
    static protected $Instances = [];

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

        $class_name = get_called_class();
        if (!isset(self::$Instances[$class_name])) {

            self::$Instances[$class_name] = new $class_name;
        }

        return self::$Instances[$class_name];
    }
}