<?php

use App\Models\Transaction;
use App\Models\User;

// TODO: Get ID from session
$user = User::find(1);
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
        'balance' => $balance,
        'transactions' => $transactions,
    ],
]));