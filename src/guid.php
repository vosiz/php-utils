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