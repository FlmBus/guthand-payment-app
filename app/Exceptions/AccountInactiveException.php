<?php

namespace App\Exceptions;

class AccountInactiveException extends \Exception implements TransactionExceptionInterface
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
