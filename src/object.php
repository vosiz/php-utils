<?php

require_once(__DIR__.'/interfaces/icomp.php');
require_once(__DIR__.'/guid.php');

abstract class SmartObject extends stdClass implements IComparable {

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
     * Interface implementation - Compares types
     */
    public function CompareType($object) {

        return $this->GetType() === $object->GetType();
    }   

    /**
     * Interface implementation - Compares object
     */
    public function Equals($object) {

        return $this->GetHash() === $object->GetHash();
    }

    /**
     * Alias for __toString()
     */
    public function ToString() {

        return $this->__toString();
    }

}