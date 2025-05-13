<?php

/**
 * General formatted exception
 * @param string $fmt message format ("%s" etc...)
 * @param array ...$args format arguments
 */
class Exceptionf extends Exception {

    public function __construct(string $fmt, ...$args) {

        $msg = sprintf($fmt, ...$args);
        return parent::__construct($msg);
    }
}

/**
 * Application failure exception
 * @param string $msg
 */
class ApplicationException extends Exception{

    public function __construct(string $msg) {

        return parent::__construct($msg);
    }
}
class_alias('ApplicationException', 'AppException');

/**
 * Unimplemented state exception
 * @param string $state state represented in string (use _toString if needed)
 */
class UnimplementedStateException extends Exceptionf {

    public function __construct(string $state) {

        return parent::__construct("Unimplemented state $state");
    }
}

