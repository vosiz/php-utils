<?php

define('NIBBLE', 4);


/**
 * Ensures variable is an array
 * @param mixed $val checked variable
 * @param array
 */
function asarray(&$val) {

    return is_array($val) ? $val : toarray($val);
}

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
 * Simple callback function
 * @param string function function name
 * @param array ...$args VA
 * @param false|mixed return of called function (default is false)
 */
function callback(string $function, ...$args) {

    if (!function_exists($function)) {

        throw new \InvalidArgumentException("Function $function does not exist.");
    }

    return $function(...$args);
}

/**
 * Class/object/instance callback
 * @param object|string|mixed $var Classname, object, instance
 * @param string $method method name
 * @param array ...$args VA
 */
function callback_cls($var, string $method, ...$args) {
    
    try {

        if (is_object($var)) {

            if (!method_exists($var, $method)) {

                throw new \Exception("Method '$method' does not exist in instance of class " . get_class($var));
            }
            return $var->$method(...$args);
        }

        if (is_string($var)) {

            if (!class_exists($var)) {

                throw new \Exception("Class '$var' does not exist.");
            }

            if (!method_exists($var, $method)) {

                throw new \Exception("Method '$method' does not exist in class '$var'.");
            }

            $refMethod = new \ReflectionMethod($var, $method);

            if ($refMethod->isStatic()) {

                return $var::$method(...$args);

            } else {

                $instance = new $var();
                return $instance->$method(...$args);
            }
        }

        throw new \Exception("Invalid callback source.");

    } catch (\Throwable $exc) {
        
        throw $exc;
    }
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
 * Creates Exceptionf (classic VARGs for formatting)
 * @return Exceptionf
 */
function excf(string $fmt, ...$args) {

    $exc = Exceptionf::Create($fmt, ...$args);
    return $exc;
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
 * Get all properties of object
 * @param object $obj object
 * @return array[] string => [name, value, type]
 */
function getprops(object $obj) {
    
    if (!is_object($obj)) return [];

    $props = [];
    $reflection = new ReflectionClass($obj);
    $properties = $reflection->getProperties();

    foreach ($properties as $p) {

        $p->setAccessible(true);

        $type = $p->isPublic() ? 'public' :
            ($p->isProtected() ? 'protected' : 'private');

        $name = $p->getName();
        $value = $p->getValue($obj);

        $props[$name] = [
            'name' => $name,
            'value' => $value,
            'type' => $type
        ];
    }

    return $props;
}

/**
 * Generates guid (hex general unique ID)
 * @param int $chars count of characters (= x2)
 * @return string GUID
 */
function guid(int $chars = 16) {

    return bin2hex(random_bytes($chars));
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
 * Get all properties of class 
 * @param string $class classname
 * @return array[string] string[name => visibility]
*/
function propsof(string $class) {

    if (!class_exists($class)) {

        throw new \Exception("Class '$class' not found.");
    }

    $reflection = new ReflectionClass($class);
    $properties = [];

    foreach ($reflection->getProperties() as $property) {

        $modifiers = Reflection::getModifierNames($property->getModifiers());
        $visibility = $modifiers[0];
        $properties[$property->getName()] = $visibility;
    }

    return $properties;
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
 * @param array $array Target array (passed by reference)
 * @param mixed $index Index or indices to remove
 * @param bool $keep keep indices
 */
function unsetra(&$array, $index, bool $keep = false) {

    $indices = is_array($index) ? $index : toarray($index);

    foreach ($indices as $i) {
        if (array_key_exists($i, $array)) {
            unset($array[$i]);
        }
    }

    if(!$keep)
        $array = array_values($array);
    else 
        return $array;
}
