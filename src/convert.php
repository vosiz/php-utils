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
 * @return string
 */
function tostr($var) {

    if (is_object($var)) { // object
        
        return method_exists($var, '__toString') ? $var->__toString() : typeof($var);

    } elseif (is_array($var)) { // array

        return json_encode($var);

    } elseif (is_bool($var)) { // bool

        return $var ? 'true' : 'false';

    } elseif ($var === null) { // null

        return 'null';
    }

    // other, scalar types
    return (string)$var;
    
}