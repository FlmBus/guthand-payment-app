<?php

namespace App\Exceptions;

interface TransactionExceptionInterface extends \Exception
{
    public function getMessage(): string;
}
