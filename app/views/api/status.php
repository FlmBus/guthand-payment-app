<?php

use App\Models\User;

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

$balance = $user->balance;

$transactions = $user->getTransactions()
    ->map(function($t) use ($user) {
        if ($t->from === null) {
            $t->direction = 'in';
            $t->type = 'deposit';
        }

        if ($t->to === null) {
            $t->direction = 'out';
            $t->type = 'withdrawal';
        }

        if ($t->from !== null && $t->to !== null) {
            $t->direction = $t->from === $user->id ? 'out' : 'in';
            $t->type = 'transfer';
        }
        return $t;
    })
    ->sortByDesc('created_at');

die(json_encode([
    'success' => true,
    'errors' => [],
    'data' => [
        'user' => $user,
        'balance' => $balance,
        'transactions' => $transactions,
    ],
]));