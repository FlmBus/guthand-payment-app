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

if ($_SESSION['logged_in'] ?? null == null) {
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

$success = User::withdrawal($user, $amount);
if ($success) {
    $t = new Transaction([
        'from' => null,
        'to' => $user->id,
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
        'errors' => [ 'could not withdraw money. Make sure to not exceed any limits' ],
        'data' => null,
    ]));
}
