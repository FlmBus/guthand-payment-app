<?php

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

// TODO: Get ID from session
$user = User::find(1);
if ($user == null) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'User not found' ],
        'data' => null,
    ]));
}

$success = User::deposit($user, $amount);
if ($success) {
    $t = new Transaction([
        'from' => $user->id,
        'to' => null,
        'amount' => $amount,
    ]);
    $t->save();
    die(json_encode([
        'success' => true,
        'errors' => [],
        'data' => [ 'new_balance' => $user->fresh()->balance ],
    ]));
} else {
    die(json_encode([
        'success' => false,
        'errors' => [ 'could not deposit money. Make sure to not exceed any limits' ],
        'data' => null,
    ]));
}
