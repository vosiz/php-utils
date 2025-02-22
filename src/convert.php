<?php

/**
 * Integer to bool (C++ like)
 * @param int $i integer to convert
 * @return bool
 */
function int2b(int $i) {

    return $i > 0;
}

/**
 * Bool to integer (C++ like)
 * @param bool $b boolean to convert
 * @return int
 */
function b2int(bool $b) {

    return $b ? 1 : 0;
}