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
     * Is NULL or empty()
     * @param mixed $object object to check
     * @return bool
     */
    public static function NullOrEmpty($object) {

        return !isset($object) || is_null($object);
    }

    /**
     * Is one of types
     * @param mixed $object object to check
     * @return bool
     */
    public static function TypeOf($object, ...$types) {
        
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
function is_noe($obj) {

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
 * @param mixed $object Variable/value to check
 * @param mixed ...$types (optional) type(s) to check
 * @return bool
 */
function is_typeof($object, ...$types) {

    return Is::TypeOf($object, ...$types);
}

