<?php

require_once(__DIR__.'/exc.php');

class ConvertException extends Exceptionf {

    public function __construct($var, string $fmt, ...$args) {

        $str = print_r($var, true);
        $fmt = sprintf("Convert failed for VAR: %s; ", $var).$fmt;
        return parent::__construct($fmt, ...$args);
    }
}


/**
 * Integer to bool (C++ like)
 * @param int $i integer to convert
 * @return bool
 */
function int2b(int $i) {

    return $i > 0;
}

/**
 * Bool to integer (C++ like)
 * @param bool $b boolean to convert
 * @return int
 */
function b2int(bool $b) {

    return $b ? 1 : 0;
}

/**
 * Converts anything to a string representation
 * @param mixed $var Variable/value
 * @param bool $to_array Tries to convert to array first (nonrecurs)
 * @return string|string[]
 */
function tostr($var, bool $to_array = false) {

    try {

        if (is_object($var)) { // object
        
            // try convert to array of strings
            if($to_array) {
    
                try{
    
                    $a = $var->ToArray();
                    $str_a = [];
                    foreach($a as $item) {
    
                        try {
    
                            $str_a[] = tostr($item);
    
                        } catch (Exception $exc) {
                    
                            return "Cannot convert object-item to string - ".method_exists($var, '__toString') ? $var->__toString() : typeof($var);
                        }
                    }
    
                    return $str_a;
    
                } catch (Exception $exc) {
            
                    return method_exists($var, '__toString') ? $var->__toString() : typeof($var);
                }
    
            } else { // convert "normally"
    
                return method_exists($var, '__toString') ? $var->__toString() : typeof($var);
            }
    
        } elseif (is_array($var)) { // array
    
            if($to_array) {

                $a = [];
                foreach($var as $k => $v) {

                    $a[$k] = tostr($v);
                }

                return $a;

            } else {

                $cumul = '';
                foreach($var as $key => $val) {
        
                    $cumul .= tostr(new KeyValuePair($key, $val)).PHP_EOL;
                }
        
                return $cumul;
            }
    
        } elseif (is_bool($var)) { // bool
    
            return $var ? 'true' : 'false';
    
        } elseif ($var === null) { // null
    
            return 'null';
        }
    
        // other, scalar types
        return (string)$var;

    } catch(\Exception $exc) {

        throw new ConvertException($exc->getMessage());
    }
    
}