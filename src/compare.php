<?php

use Vosiz\Utils\Collections\Collection;

class Is {

    /**
     * Is Vosiz\Utils\Collections\Collection/Collection
     * @param mixed $object object to check
     * @return bool
     */
    public static function Collection($object) {

        return $object instanceof Collection;
    }

    /**
     * Is \SmartObject
     * @param mixed $object object to check
     * @return bool
     */
    public static function SmartObject($object) {
        
        return $object instanceof \SmartObject;
    }

    /**
     * Is NULL, empty string, empty array or empty Collection
     * 0, '0' and false are values, not empty (unlike empty())
     * @param mixed $object object to check
     * @return bool
     */
    public static function NullOrEmpty($object) {

        if($object === null || $object === '' || $object === [])
            return true;

        return $object instanceof Collection && $object->IsEmpty();
    }

    /**
     * Is one of types (object matches also its parent classes and interfaces)
     * @param mixed $object object to check
     * @return bool
     */
    public static function TypeOf($object, ...$types) {
        
        if (empty($types)) {

            throw new InvalidArgumentException('No types defined to check against.');
        }
    
        $object_type = typeof($object);
        foreach ($types as $type) {
            
            if ($object_type === $type || $object instanceof $type) {
                return true;
            }
        }
    
        return false;
    }
}


/**
 * Check if object is collection
 * @param mixed $object object to check
 * @return bool
 */
function is_collection($object) {

    return Is::Collection($object);
}

/** 
 * Is null or empty
 * @param object Object to check
 * @return bool
 */
function is_noe($object) {

    return Is::NullOrEmpty($object);
}

/**
 * Check if object is smart object
 * @param mixed $object object to check
 * @return bool
 */
function is_smarto($object) {

    return Is::SmartObject($object);
}

/**
 * Check if variable is PHP primitive data type (native primitive)
 * @param mixed $var to check
 */
function is_prim($var) {

    switch(typeof($var)) {

        case 'integer':
        case 'double':
        case 'float':
        case 'string':
        case 'boolean':
        case 'NULL':
            return true;

        default:
            return false;
    }
}

/**
 * @param mixed $object Variable/value to check
 * @param mixed ...$types (optional) type(s) to check
 * @return bool
 */
function is_typeof($object, ...$types) {

    return Is::TypeOf($object, ...$types);
}

