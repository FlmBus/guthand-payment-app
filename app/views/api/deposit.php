<?php

use App\Exceptions\TransactionExceptionInterface;
use App\Models\Transaction;
use App\Models\User;

try {
    $reqBody = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $amount = $reqBody['amount'] ?? null;
} catch (\Exception $ex) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'invalid body' ],
        'data' => null,
    ]));
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == null) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'Nicht eingeloggt' ],
        'data' => null,
    ]));
}

$user = User::find($_SESSION['logged_in']);

if ($user == null) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'Ihr Konto wurde nicht gefunden. Bitte loggen Sie sich aus und wieder ein.' ],
        'data' => null,
    ]));
}

try {
    User::deposit($user, $amount);
    $t = new Transaction([
        'from' => $user->id,
        'to' => null,
        'amount' => $amount,
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
