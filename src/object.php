<?php

require_once(__DIR__.'/interfaces/icomp.php');
require_once(__DIR__.'/guid.php');

abstract class SmartObject extends stdClass implements IComparable {

    private $Type;  public function GetType() { return $this->Type; }
    private $Hash;

    /**
     * Constructor
     */
    public function __construct() {

        $this->Type = get_called_class();
    }

    /**
     * To string
     */
    public function __toString() {

        return $this->GetType();
    }

    /**
     * Unique id of instance, created on first use
     * @return string
     */
    public function GetHash() {

        if($this->Hash === null)
            $this->Hash = new Guid();

        return $this->Hash->__toString();
    }

    /**
     * Interface implementation - Compares types
     */
    public function CompareType($object) {

        return $object instanceof SmartObject && $this->GetType() === $object->GetType();
    }   

    /**
     * Interface implementation - Compares object
     */
    public function Equals($object) {

        return $object instanceof SmartObject && $this->GetHash() === $object->GetHash();
    }

    /**
     * Alias for __toString()
     */
    public function ToString() {

        return $this->__toString();
    }

}