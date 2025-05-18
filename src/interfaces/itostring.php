<?php

interface IToString {

    /**
     * Represents object as string
     * @param mixed $object to be casted to string
     * @return string
     */
    public static function AsString($object) : string;

    /**
     * Represents instance of class as string
     * @param string $fmt (optional) output format
     * @return string
     */
    public function ToString(string $fmt = null) : string;
}