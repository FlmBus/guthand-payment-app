<?php

use App\Exceptions\AccountNotFoundException;
use App\Exceptions\TransactionExceptionInterface;
use App\Models\Transaction;
use App\Models\User;

try {
    $reqBody = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $iban = $reqBody['iban'] ?? null;
    $amount = $reqBody['amount'] ?? null;
    $message = $reqBody['message'] ?? null;

    // TODO: Get ID from session
    if ($_SESSION['logged_in'] ?? null == null) {
        throw new Exception();
    }

    $from = User::find($_SESSION['logged_in']);

    $to = User::where('iban', $iban)->first();
    if ($to == null || $amount == null) throw new \Exception();
} catch (\Exception $ex) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'Ungültige Anfrage' ],
        'data' => null,
    ]));
}


$errors = [];
try {
    if ($from == null || $to == null) {
        throw new AccountNotFoundException('Konto konnte nicht gefunden werden.');
    }
    User::transfer($from, $to, $amount);
    $t = new Transaction([
        'from' => $from->id,
        'to' => $to->id,
        'amount' => $amount,
        'message' => $message,
    ]);
    $t->save();
} catch(TransactionExceptionInterface $ex) {
    $errors[] = $ex->getMessage();
}

die(json_encode([
    'success' => empty($errors),
    'errors' => $errors,
    'data' => [
        'new_balance' => $from->fresh()->balance
    ],
]));

