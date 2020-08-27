<?php

use App\Models\User;

try {
    $reqBody = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $iban = $reqBody['iban'] ?? null;
    $password = $reqBody['password'] ?? null;

    // Abort on incomplete body
    if ($iban == null || $password == null) {
        throw new \Exception();
    }

    // Fetch user from database
    $user = User::where('iban', $iban)->first();

    // If not found: abort
    if ($user == null) {
        throw new \Exception();
    }

    // If inactive: abort
    if (!$user->active) {
        throw new \Exception();
    }

    // If password incorrect: abort
    if (!$user->authenticate($password)) {
        throw new \Exception();
    }

    // Log user in
    $_SESSION['logged_in'] = $user->id;

} catch (\Exception $ex) {
    die(json_encode([
        'success' => false,
        'errors' => [ 'Error' ],
        'data' => null,
    ]));
}

die(json_encode([
    'success' => true,
    'errors' => [],
    'data' => null,
]));
