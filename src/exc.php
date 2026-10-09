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

    public static function CreateInner(\Throwable $inner, $fmt, ...$args) {

        $exc = self::Create($fmt, ...$args);
        $exc->SetInner($inner);
        return $exc;
    }

    public static function AsString($object) : string{

        return $object instanceof Exceptionf ? $object->ToString() : $object->__toString();
    }

    public function __construct(string $fmt, ...$args) {

        // $this->Setup();
        $msg = empty($args) ? $fmt : sprintf($fmt, ...$args);
        parent::__construct($msg);
    }

    public function ToString($fmt = null) : string {

        $str = $this->IsChild ? $this->getMessage() : '[EXCf]: '.$this->getMessage();
        return $str.$this->InnerToString(0);
    }

    public function SetInner(\Throwable $exc) {

        $this->Inner = $exc;
        if($exc instanceof Exceptionf)
            $exc->IsChild = true;
    }

    public function SetInnerExc(string $fmt, ...$args) {

        return $this->SetInner(excf($fmt, ...$args));
    }


    /**
     * Inner chain as indented lines, one per level
     * @param int $depth level of indentation
     * @return string
     */
    protected function InnerToString(int $depth) {

        if($this->Inner === null)
            return '';

        $inner = $this->Inner;
        $line  = PHP_EOL.str_repeat('  ', $depth).'- ';

        if($inner instanceof Exceptionf)
            return $line.$inner->getMessage().$inner->InnerToString($depth + 1);

        return $line.get_class($inner).': '.$inner->getMessage();
    }

}

/**
 * Application failure exception
 * @param string $msg
 */
class ApplicationException extends Exception {

    public function __construct(string $msg) {

        parent::__construct($msg);
    }
}
class_alias('ApplicationException', 'AppException');

/**
 * Unimplemented state exception
 * @param string $state state represented in string (use _toString if needed)
 */
class UnimplementedStateException extends Exceptionf {

    public function __construct(string $state) {

        parent::__construct("Unimplemented state $state");
    }
}

