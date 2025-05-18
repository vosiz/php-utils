<?php

require_once(__DIR__.'/interfaces/itostring.php');
// require_once(__DIR__.'/traits/thierarchy.php');

/**
 * General formatted exception
 * @param string $fmt message format ("%s" etc...)
 * @param array ...$args format arguments
 */
class Exceptionf extends Exception implements IToString {

    //use THierarchy;

    protected $Inner;   public function GetInner() {    return $this->Inner;}
    protected $IsChild = false;

    public static function Create(string $fmt, ...$args) {

        return new Exceptionf($fmt, ...$args);
    }

    public static function CreateInner(Exceptionf $inner, $fmt, ...$args) {

        $exc = self::Create($fmt, ...$args);
        $exc->SetInner($inner);
        return $exc;
    }

    public static function AsString($object) : string{

        return Is::TypeOf($object, 'Exceptionf') ? $object->ToString() : $object->__toString();
    }

    public function __construct(string $fmt, ...$args) {

        // $this->Setup();
        $msg = sprintf($fmt, ...$args);
        return parent::__construct($msg);
    }

    public function ToString($fmt = null) : string {

        if($this->IsChild) {

            return $this->getMessage().' ';

        } else {

            $str = '[EXCf]: '.$this->getMessage();
            if($this->Inner !== null)
                $str .= PHP_EOL.'- '.$this->Inner->ToString();
            return $str;
        }
    }

    public function SetInner(Exceptionf $exc) {  
    
        $this->Inner = $exc;
        $exc->IsChild = true;
    }

    public function SetInnerExc(string $fmt, ...$args) {

        return $this->SetInner(excf($fmt, ...$args));
    }

}

/**
 * Application failure exception
 * @param string $msg
 */
class ApplicationException extends Exception {

    public function __construct(string $msg) {

        return parent::__construct($msg);
    }
}
class_alias('ApplicationException', 'AppException');

/**
 * Unimplemented state exception
 * @param string $state state represented in string (use _toString if needed)
 */
class UnimplementedStateException extends Exceptionf {

    public function __construct(string $state) {

        return parent::__construct("Unimplemented state $state");
    }
}

