<?php

namespace App\Models;

use App\Exceptions\AccountInactiveException;
use App\Exceptions\DepositLimitExceededException;
use App\Exceptions\InsufficientFundsException;
use App\Exceptions\InvalidAmountException;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    private static float $max_overdraw = 200.00;
    private static float $max_deposit = 5000.00;

    public $timestamps = false;

    public $hidden = [
        'email',
        'password',
        'balance',
    ];

    public function getTransactions() {
        return Transaction::with(['from', 'to'])
            ->where('from', $this->id)
            ->orWhere('to', $this->id)
            ->get();
    }

    public function setPasswordAttribute(string $value): User {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT);
        return $this;
    }

    public function authenticate(string $password): bool {
        return password_verify($password, $this->password);
    }

    public static function withdrawal(User $user, float $amount) {
        // Disallow negative amounts
        if ($amount < 0) throw new InvalidAmountException('Negative Werte sind nicht erlaubt.');

        // Refresh entity to avoid inconsistency
        $user = $user->fresh();

        // Abort if account is inactive
        if (!$user->active) throw new AccountInactiveException('Ihr Konto ist inaktiv.');

        // Calculate new balance
        $new_balance = $user->balance - $amount;

        // Abort if account is overdrawn too much
        if ($new_balance < 0) {
            $msg = sprintf('You cannot overdraw your account by withdrawal.');
            throw new InsufficientFundsException($msg);
        }

        // Set balance and save
        $user->balance = $new_balance;
        $user->save();
    }

    public static function deposit(User $user, float $amount) {
        // Disallow negative amounts
        if ($amount < 0) throw new InvalidAmountException('Negative Werte sind nicht erlaubt.');

        // Abort if amount exceeds the maximum for deposits
        if ($amount > self::$max_deposit) {
            $msg = sprintf('You cannot deposit more than %d €', self::$max_deposit);
            throw new DepositLimitExceededException($msg);
        }

        // Refresh entity to avoid inconsistency
        $user = $user->fresh();

        // Abort if account is inactive
        if (!$user->active) throw new AccountInactiveException('Ihr Konto ist inaktiv.');

        // Add amount to balance and save
        $user->balance = $user->balance + $amount;
        $user->save();
    }

    public static function transfer(User $from, User $to, float $amount) {
        // Disallow negative amounts
        if ($amount < 0) throw new InvalidAmountException('Negative Werte sind nicht erlaubt.');

        // Refresh entities to avoid inconsistency
        $from = $from->fresh();
        $to = $to->fresh();

        // Abort if one of the accounts is inactive
        if (!$from->active) throw new AccountInactiveException('Ihr Konto ist inaktiv.');
        if (!$to->active) throw new AccountInactiveException('Das Konto der Empfängers ist inaktiv.');

        // Calculate new balances
        $from_balance = $from->balance - $amount;
        $to_balance = $to->balance + $amount;

        // Abort if account is overdrawn too much
        if ($from_balance < self::$max_overdraw) {
            $msg = sprintf('You cannot overdraw by more than %d €.', self::$max_overdraw);
            throw new InsufficientFundsException($msg);
        }

        // Set new balances
        $from->balance = $from_balance;
        $to->balance = $to_balance;

        // Save changes
        $from->save();
        $to->save();
    }
}
