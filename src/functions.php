<?php

define('NIBBLE', 4);

/** 
 * Mask and rotate integer 
 * @param int $value Input value (preferably 32bit integer)
 * @param int $mask Bitmask
 * @param int $rorate How many bits to rotate right
 * @return int
*/
function bitmask($value, $mask = 0xFFFFFFFF, $rotate = 0) {

    return ($value&($mask)) >> $rotate;
}

/** 
 * Simple callback
 * @param object $inst Instance of object
 * @param string $method Method to call
 * @param array $args Method arguments
 */
function callback($inst, $method, $args = []) {
    
    call_user_func_array([$inst, $method], $args);
}

/**
 * Gets defined class list
 * @return string[]
 */
function classlist() { 
    
    return get_declared_classes();
}

/** 
 * Creates Exception by message
 * @param string $msg Exception message
 * @return Exception
*/
function exc(string $msg) {

    $exc = new Exception($msg);
    return $exc;
}

/** 
 * Fatal by string
 * @param string $msg Text to show
*/
function fatal($msg) {

    echo $msg.PHP_EOL;
    exit;
}

/** 
 * Fatal by exception
 * @param Exception $exc Exception
*/
function fatalexc(Exception $exc) {

    fatal($exc->getMessage());
}

/** 
 * Get value if set or default
 * @param mixed $obj Object ro examine
 * @param mixed $key If array - key
 * @param mixed $default Optional, if not set return default
 * @return mixed Setup value or default
*/
function getifset($obj, $key = null, $default = null) {

    if (is_array($obj) && $key !== null) {

        return isset($obj[$key]) ? $obj[$key] : $default;
    }

    return isset($obj) ? $obj : $default;
}

/** 
 * Instantiate class by name
 * @param string $class Class name
 * @param mixed ...$args Vargs
*/
function instclass(string $class, ...$args) {

    if (class_exists($class)) {
        $inst = new $class(...$args);
        return $inst;
    }
        
    fatal("Class $class not defined");
}

/** 
 * Is null or empty
 * @param object Object to check
 * @return bool
*/
function is_noe($obj) {

    return !isset($obj) || is_null($obj);
}

/**
 * @param mixed $object Variable/value to check
 * @param mixed ...$types (optional) type(s) to check
 */
function is_typeof($object, ...$types) {

    if (empty($types)) {

        throw new InvalidArgumentException('No types defined to check against.');
    }

    $object_type = typeof($object);
    foreach ($types as $type) {
        
        if ($object_type === $type) {
            return true;
        }
    }

    return false;
}

/** 
 * Add value to list/array
 * @param array $list Ref array/list
 * @param mixed $value Value to add
 * @param mixed|null $key Key, if not set, add by default
*/
function listadd(&$list, $value, $key = null) {

    if(is_null($key)) {

        $list[] = $value;

    } else {

        $list[$key] = $value;
    }
}

/** 
 * Get today/now
 * @param string $format Datetime formating
 * @return string
*/
function now($format = 'Y-m-d H:i:s') {

    return date($format);
}

/** 
 * Check if set, set to default if not, return value if set
 * @param mixed|null $obj Object to check
 * @param mixed|null $key If object is array and testing array key/value
 * @param mixed|null $val Value to setup to if not set
 * @return mixed
*/
function setifnset(&$obj, $key = null, $val = null) {

    if (is_array($obj) && $key !== null) {

        if(isset($obj[$key]))
            return $obj[$key];

        $obj[$key] = $val;
        return $val;
    } 

    if(isset($obj))
        return $obj;

    $obj = $val;
    return $obj;
}

/** 
 * Format string to CamelCase
 * @param string $str Input string
 * @return string
*/
function str_camel(string $str) {

    return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
}

/**
 * Convert value to array eventually
 * @param mixed $val Object/value or array
 * @return array
 */
function toarray($val) {

    return is_array($val) ? $val : [$val];
}

/** 
 * Gets type as string (class or type name)
 * @param mixed $object Variable/value to check
 * @return string
*/
function typeof($object) {

    $type = gettype($object);

    if($type === "object")
        return get_class($object);

    return $type;
}

/**
 * Unset and reorder array
 * @param array $array Target array
 * @param mixed $index Index or indeces in array
 */
function unsetra(&$array = array(), $index) {

    if(is_array($index)) {

        foreach($index as $i) {

            unsetra($array, $i);
        }

        return;
    }

    if(key_exists($index, $array)) {

        unset($array[$index]);
    }

    $array = array_values($array);
}
