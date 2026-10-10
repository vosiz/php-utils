<?php

namespace Vosiz\Utils\Collections;

/**
 * General Collection exception
 * @param string $msg exception message
 * @throws Vosiz\Utils\CollectionException
 */
class CollectionException extends \Exception {

    public function __construct(string $msg) {

        parent::__construct($msg);
    }
}

class DictionaryException extends CollectionException {

}