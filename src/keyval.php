<?php

class KeyValuePairException extends Exception {

    /**
     * Constructor - parent-based
     */
    public function __construct($msg) {

        return parent::__construct($msg);
    }
}

class KeyValuePair {

    protected $Key;         public function GetKey() { return $this->Key;               }
    protected $Value;       public function GetValue() { return $this->Value;           }
    protected $KeyClass;    public function GetKeyClass() { return $this->KeyClass;     }
    protected $ValueClass;  public function GetValueClass() { return $this->ValueClass; }

    /**
     * Constructor
     * @param mixed $key Identifier
     * @param mixed $value Value
     */
    public function __construct($key, $value) {

        if($key === NULL)
            throw new KeyValuePairException("Key cannot be null");

        $this->Key = $key;
        $this->Value = $value;
        $this->KeyClass = typeof($key);
        $this->ValueClass = typeof($value);
    }

    /**
     * Compares values
     * @param mixed $value Value to be compared
     */
    public function Compare($value) {

        return $this->Value == $value;
    }
}

class_alias("KeyValuePair", "Keyvalp");
class_alias("KeyValuePair", "KeyValPair");


class KeyValuePairStrict extends KeyValuePair {

    /**
     * Constructor
     * @param mixed $key Identifier
     * @param mixed $value Value
     */
    public function __construct($key, $value) {

        if(!is_numeric($key) && !is_string($key)) {

            throw new KeyValuePairException("Key is not valid array-based key (not string nor int)");
        }

        return parent::__construct($key, $value);
    }
}

class_alias("KeyValuePairStrict", "Keyvalps");
class_alias("KeyValuePairStrict", "KeyValPairStrict");