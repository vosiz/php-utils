<?php

namespace Vosiz\Utils\Collections;

require_once(__DIR__.'/../keyval.php');
require_once(__DIR__.'/../object.php');
require_once(__DIR__.'/exc.php');


class Dictionary extends \SmartObject implements \IteratorAggregate {

    private $Temp = []; // temp data, original key/value
    private $Kvps = []; // more modern, keyvaluepair-based

    /**
     * Converts array to Dictionary
     * @param array $a array
     * @return Dictionary
     */
    public static function ToDictionary(array $a = array()) {

        return new Dictionary($a);
    }

    /** Base constructor - optional values 
     * @param array $value values to add
    */
    public function __construct(array $values = array()) {

        parent::__construct();
        foreach($values as $k => $v) {

            $this->Add($v, $k);
        }
    }

    /**
     * Get property-like magic
     * @param string $key key/property
     * @return mixed|null null when not found
     */
    public function __get(string $key) {

        $key = str_camel($key);
        return getifset($this->Temp, $key);
    }

    /** Classic toString override
     * @return string toString representation
    */
    public function __toString() {

        $text = "Vosiz/Utils/Dictionary";
        if(!$this->IsEmpty()) {
            $text .= ": cnt=".$this->Count();
            $text .= " {";
            foreach($this->Temp as $key => $item) {
                $text .= "<br> - [$key] => ".tostr($item);
            }
            $text .= " }";
        }

        return $text;
    }

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

                    throw new DictionaryException("Key already exists");
                }

            } else {

                $this->Temp[$key] = $object;
                $kvps = new \KeyValuePairStrict($key, $object);
                $this->Kvps[$key] = $kvps;
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
     * Remove member(s) from Dictionary
     * @param mixed $index Index/indices to be removed
     * @param bool $keep keeps indeces
     */
    public function Remove($index, bool $keep = false) {

        asarray($index);
        unsetra($this->Temp, $index, $keep);
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

        $this->Temp = array();
    }

    /**
     * Intersect, value-based, distincts values with diff. keys
     * @param array $a intersection array
     * @return Dictionary
     */
    public function Intersect(array $a = array()) {

        return array_intersect($this->ToArray(), $a);
    }

    /**
     * Merge Dictionary to this
     * @param Dictionary $c Dictionary to merge
     * @param bool $rewrite when keys are same (true = rewrites with new value)
     */
    public function Merge(Dictionary $c, bool $rewrite = false) {

        $this->AddRange($c->ToArray(), $rewrite);
    }

    /**
     * Count of members
     * @return int
     */
    public function Count() {

        return count($this->Temp);
    }

    /**
     * Has key
     * @param int|string $key questioned key
     * @return bool true if present
     */
    public function HasKey($key) {

        return array_key_exists($key, $this->Temp);
    }

    /**
     * Has value
     * @param mixed $object questioned value
     * @return bool true if present
     */
    public function HasValue($value) {

        return in_array($value, $this->Temp);
    }

    /**
     * Gets index/key by value
     * @param mixed $value questioned value
     * @return int|string|false index or fail
     */
    public function IndexOf($value) {

        return array_search($value, $this->Temp);
    }

    /**
     * Check if it is empty
     * @return bool empty
     */
    public function IsEmpty() {

        return $this->Count() == 0; 
    }

    /** 
     * Get keys (all or with filtration)
     * @param array ...$filter_values every value to filtrate on (none means all keys)
     * @return mixed keys
    */
    public function Keys(...$filter_values): array {

        if (empty($filter_values)) {
            return array_keys($this->Temp);
        }

        $keys = [];

        // fixing va as array
        if(is_array($filter_values))
            $filter_values = current($filter_values);

        foreach ($filter_values as $value) {
            $keys = array_merge($keys, array_keys($this->Temp, $value, true));
        }

        return array_unique($keys);
    }

    /**
     * Convert to array
     * @return array
     */
    public function ToArray() {

        return $this->Temp;
    }

    /**
     * Convert to KeyValuePair array
     * @return KeyValuePair[]
     */
    public function ToPairs() {

        return $this->Kvps;
    }

    /**
     * Get values
     * @return array
     */
    public function Values() {

        return array_values($this->Temp);
    }

    /**
     * Alias for ToArray
     * @return array
     */
    public function AsArray() {
        
        return $this->Temp;
    }

    /**
     * Alias for Count
     * @return int
     */
    public function Length() {

        return $this->Count();
    }

    /**
     * Alias for HasValue
     * @param mixed $object questioned value
     * @return bool true if present
     */
    public function Contains($object) {

        return $this->HasValue($object);
    }

    /**
     * Alias to IndexOf
     * @param mixed $value questioned value
     * @return int|string|false index
     */
    public function Find($value) {

        return $this->IndexOf($value);
    }

    /**
     * Finds all indeces of values
     * @param array $values Searched
     * @return array
     */
    public function FindAll($values = array()) {

        return $this->Keys($values);
    }
}