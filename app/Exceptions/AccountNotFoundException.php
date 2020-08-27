<?php

namespace App\Exceptions;

class AccountNotFoundException extends \Exception implements TransactionExceptionInterface
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}