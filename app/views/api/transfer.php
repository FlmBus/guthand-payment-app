<?php

use App\Models\Transaction;
use App\Models\User;

try {
    $reqBody = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $iban = $reqBody['iban'] ?? null;
    $amount = $reqBody['amount'] ?? null;
    
    // TODO: Get ID from session
    $from = User::find(1);
    $to = User::where('iban', $iban)->first();
    if ($to == null || $amount == null) throw new \Exception();
} catch (\Exception $ex) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'invalid body' ],
        'data' => null,
    ]));
}

if ($from == null || $to == null) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'User not found' ],
        'data' => null,
    ]));
}

$success = User::transfer($from, $to, $amount);
if ($success) {
    $t = new Transaction([
        'from' => $from->id,
        'to' => $to->id,
        'amount' => $amount,
    ]);
    $t->save();
    die(json_encode([
        'success' => true,
        'errors' => [],
        'data' => [ 'new_balance' => $from->fresh()->balance ],
    ]));
} else {
    die(json_encode([
        'success' => false,
        'errors' => [ 'could not transfer money. Make sure to not exceed any limits' ],
        'data' => null,
    ]));
}
