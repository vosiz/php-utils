<?php

namespace Vosiz\Utils;

/**
 * General formatted exception
 * @param string $fmt message format ("%s" etc...)
 * @param array ...$args format arguments
 */
class Exceptionf extends \Exception {

    public function __construct(string $fmt, ...$args) {

        $msg = sprintf($fmt, ...$args);
        return parent::__construct($msg);
    }
}