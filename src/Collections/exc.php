<?php

namespace Vosiz\Utils\Collection;

/**
 * General Collection exception
 * @param string $msg exception message
 * @throws Vosiz\Utils\CollectionException
 */
class CollectionException extends \Exception {

    public function __construct(string $msg) {

        return parent::__construct($msg);
    }
}