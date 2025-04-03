<?php

class Guid {

    private $String;

    /**
     * Constructor
     */
    public function __construct() {

        $this->String = guid();
    }

    /**
     * To string
     */
    public function __toString() {

        return $this->String;
    }
}

abstract class SmartObject extends stdClass {

    private $Type;  public function GetType() { return $this->Type;                 }
    private $Hash;  public function GetHash() { return $this->Hash->__toString();   }

    /**
     * Constructor
     */
    public function __construct() {

        $this->Type = get_called_class();
        $this->Hash = new Guid();
    }

    /**
     * To string
     */
    public function __toString() {

        return $this->GetType();
    }

    /**
     * Check equality
     * @param SmartObject $obj object to compare
     */
    public function Equals(SmartObject $obj) {

        return $this->GetHash() === $obj->GetHash();
    }

    /**
     * Alias for __toString()
     */
    public function ToString() {

        return $this->__toString();
    }
}