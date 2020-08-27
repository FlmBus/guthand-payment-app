<?php

namespace App\Exceptions;

class AccountInactiveException extends  TransactionException
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
