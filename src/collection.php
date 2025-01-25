<?php

namespace Vosiz\Utils;

class Collection {

    private $Data = [];

    /** Base constructor - optional values 
     * @param array $value values to add
    */
    public function __construct(array $values = array()) {

        foreach($values as $k => $v) {

            $this->Add($v, $k);
        }
    }

    /** Classic toString override
     * @return string toString representation
    */
    public function __toString() {

        $text = "APIkor/Collection";
        if(!$this->IsEmpty()) {
            $text .= ": cnt=".$this->Count();
        }

        return $text;
    }


    /** 
     * Adds value
     * @param mixed $object object to add
     * @param int|string $key identification key
     * @param bool $update_existing if true updates value, throws exception on existing key if false
     * @return bool success
     * @throws CollectionException
    */
    public function Add($object, $key = NULL, bool $update_existing = false) {

        if($key === NULL) {

            $this->Data[] = $object;
            return true;

        } else {

            if(array_key_exists($key, $this->Data)) {

                if($update_existing) {

                    $this->Data[$key] = $object;
                    return true;

                } else {

                    throw new CollectionException("Key already exists");
                }

            } else {

                $this->Data[$key] = $object;
            }
        }
    }

    /** 
     * Adds multiple values
     * @param mixed[] $data objects to add
     * @param bool $update_existing if true updates value, throws exception on existing key if false
     * @return bool success
    */
    public function AddRange(array $data = array(), bool $update_existing = false) {

        $res = true;
        foreach($data as $k => $v) {

            if(!$this->Add($v, $k, $update_existing)) 
                $res = false;
        }

        return $res;
    }

    /**
     * Converts to array
     * @return array
     */
    public function AsArray() {
        
        return $this->Data;
    }
    
    /** 
     * Clears data
    */
    public function Clear() {

        $this->Data = array();
    }

    /**
     * Count of members
     * @return int
     */
    public function Count() {

        return count($this->Data);
    }

    /**
     * Contains value
     * @param mixed $object questioned value
     * @return bool true if present
     */
    public function Contains($object) {

        return $this->HasValue($object);
    }

    /**
     * Has key
     * @param int|string $key questioned key
     * @return bool true if present
     */
    public function HasKey($key) {

        return array_key_exists($key, $this->Data);
    }

    /**
     * Has value
     * @param mixed $object questioned value
     * @return bool true if present
     */
    public function HasValue($value) {

        return in_array($value, $this->Data);
    }

    /**
     * Gets index/key by value
     * @param mixed $value questioned value
     * @return int|string|false index or fail
     */
    public function IndexOf($value) {

        array_search($value, $this->Data);
    }

    /**
     * Check if it is empty
     * @return bool empty
     */
    public function IsEmpty() {

        return $this->Count() == 0; 
    }

    /** 
     * Get keys
     * @return mixed keys
    */
    public function Keys() {

        return array_keys($this->Data);
    }

    /**
     * Get length of array
     * @return int
     */
    public function Length() {

        return $this->Count();
    }

    /**
     * Convert to array
     * @return array
     */
    public function ToArray() {

        return $this->Data;
    }

    /**
     * Get values
     * @return array
     */
    public function Values() {

        return array_values($this->Data);
    }

}