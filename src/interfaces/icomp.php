<?php

namespace Vosiz\Utils;

interface IComparable {

    /**
     * Compares with given object type
     * @param mixed $object object to compare
     * @return bool same
     */
    public function CompareType($object);

    /**
     * Compares instances
     * @param mixed $object object to compare
     * @return bool same
     */
    public function Equals($object);
}