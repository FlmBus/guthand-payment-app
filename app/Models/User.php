<?php

namespace App\Models;

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

    public static function withdrawal(User $user, float $amount): bool {
        // Disallow negative amounts
        if ($amount < 0) return false;

        // Refresh entity to avoid inconsistency
        $user = $user->fresh();

        // Calculate new balance
        $new_balance = $user->balance - $amount;

        // Abort if account is overdrawn too much
        if ($new_balance < 0) return false;

        // Set balance and save
        $user->balance = $new_balance;
        $user->save();

        return true;
    }

    public static function deposit(User $user, float $amount): bool {
        // Disallow negative amounts
        if ($amount < 0) return false;

        // Abort if amount exceeds the maximum for deposits
        if ($amount > self::$max_deposit) return false;

        // Refresh entity to avoid inconsistency
        $user = $user->fresh();

        // Add amount to balance and save
        $user->balance = $user->balance + $amount;
        $user->save();

        return true;
    }

    public static function transfer(User $from, User $to, float $amount): bool {
        // Disallow negative amounts
        if ($amount < 0) return false;

        // Refresh entities to avoid inconsistency
        $from = $from->fresh();
        $to = $to->fresh();

        // Calculate new balances
        $from_balance = $from->balance - $amount;
        $to_balance = $to->balance + $amount;

        // Abort if account is overdrawn too much
        if ($from_balance < self::$max_overdraw) {
            return false;
        }

        // Set new balances
        $from->balance = $from_balance;
        $to->balance = $to_balance;

        // Save changes
        $from->save();
        $to->save();

        return true;
    }
}
