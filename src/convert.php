<?php

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
 * @param bool
 * @return string
 */
function tostr($var, bool $try_arrays = false) {

    if (is_object($var)) { // object
        
        if($try_arrays) {

            try{

                $a = $var->ToArray();
                foreach($a as $item) {

                    try {

                        tostr($item);

                    } catch (Exception $exc) {
                
                        return "Cannot convert to array - ".method_exists($var, '__toString') ? $var->__toString() : typeof($var);
                    }
                }

            } catch (Exception $exc) {
        
                return method_exists($var, '__toString') ? $var->__toString() : typeof($var);
            }
        }

        return method_exists($var, '__toString') ? $var->__toString() : typeof($var);

    } elseif (is_array($var)) { // array

        $cumul = '';
        foreach($var as $key => $val) {

            $cumul .= tostr(new KeyValuePair($key, $val))."<br>";
        }

        return $cumul;

    } elseif (is_bool($var)) { // bool

        return $var ? 'true' : 'false';

    } elseif ($var === null) { // null

        return 'null';
    }

    // other, scalar types
    return (string)$var;
    
}