<?php

namespace Vosiz\Utils\Collections;

require_once(__DIR__.'/../keyval.php');

class Dictionary extends Collection {

    protected $ToStringName = "Vosiz/Utils/Dictionary";
    private $Kvps = []; // more modern, keyvaluepair-based

    /**
     * Converts array to Dictionary
     * @param array $a array
     * @return Dictionary
     */
    public static function ToDictionary(array $a = array()) {

        return new Dictionary($a);
    }

    /**
     * Returns iterator
     * @return KeyValuePairStrict[]
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->Kvps as $pair) {
            yield $pair->getKey() => $pair->getValue();
        }
    }


    /** 
     * Adds value
     * @param mixed $object object to add
     * @param mixed $key identification key
     * @param bool $update_existing if true updates value, throws exception on existing key if false
     * @return bool success
     * @throws DictionaryException
    */
    public function Add($object, $key = NULL, bool $update_existing = false) {

        // restriction check
        if(($object instanceof \KeyValuePair) && !($object instanceof \KeyValuePairStrict)) {
            
            throw new DictionaryException("Dictionary cannot be used with KeyValuePair, use KeyValuePairStrict instead");
        }

        if($object instanceof \KeyValuePairStrict) {

            $key = $object->GetKey();
            $this->Kvps[$key] = $object;
            $object = $object->GetValue();
        }

        if($key === NULL) {

            $this->Temp[] = $object;
            end($this->Temp);
            $key = key($this->Temp);
            $kvps = new \KeyValuePairStrict($key, $object);
            $this->Kvps[$key] = $kvps;
            return true;

        } else {

            $key = str_camel($key);
            if(array_key_exists($key, $this->Temp)) {

                if($update_existing) {

                    $this->Temp[$key] = $object;
                    $kvps = new \KeyValuePairStrict($key, $object);
                    $this->Kvps[$key] = $kvps;
                    return true;

                } else {

                    throw new CollectionException("Key already exists");
                }

            } else {

                $this->Temp[$key] = $object;
                $kvps = new \KeyValuePairStrict($key, $object);
                $this->Kvps[$key] = $kvps;
            }
        }
    }


    /**
     * Remove member(s) from Dictionary
     * @param mixed $index Index/indices to be removed
     * @param bool $keep keeps indeces
     */
    public function Remove($index, bool $keep = false) {

        parent::Remove($index, $keep);
        unsetra($this->Kvps, $index, $keep);
    }

    /**
     * Remove all except these (value-based), distincts same values with diff. keys
     * @param array $excepts what to keep
     * @param bool $keep keeps indeces
     */
    public function RemoveExcept(array $excepts = array(), bool $keep = false) {

        $to_keep = self::ToDictionary($this->Intersect($excepts));
        $this->Clear();
        $this->Merge($to_keep);
    }
    
    /** 
     * Clears Temp
    */
    public function Clear() {

        parent::Clear();
        $this->Kvps = array();
    }

    /**
     * Convert to KeyValuePair array
     * @return KeyValuePair[]
     */
    public function ToPairs() {

        return $this->Kvps;
    }

}