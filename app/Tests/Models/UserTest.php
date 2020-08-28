<?php declare(strict_types=1);

namespace App\Tests\Models;

use App\Exceptions\AccountInactiveException;
use App\Exceptions\DepositLimitExceededException;
use App\Exceptions\InsufficientFundsException;
use PHPUnit\Framework\TestCase;
use App\Models\User;

final class UserTest extends TestCase
{
    public function testWithdrawMoney(): void {
        $user = new User([
            'active' => 1,
            'balance' => 500,
        ]);

        User::withdrawal($user, 250);

        $this->assertEquals(250, $user->balance);
    }

    public function testFailsToOverdrawByWithdrawing(): void {
        $user = new User([
            'active' => 1,
            'balance' => 1000,
        ]);

        $this->expectException(InsufficientFundsException::class);

        User::withdrawal($user, 1001);
    }

    public function testDepositMoney(): void {
        $user = new User([
            'active' => 1,
            'balance' => 500,
        ]);

        User::deposit($user, 250);

        $this->assertEquals(750, $user->balance);
    }

    public function testFailsToDepositMoreThan5000Euros(): void {
        $user = new User([
            'active' => 1,
            'balance' => 0,
        ]);

        $this->expectException(DepositLimitExceededException::class);

        User::deposit($user, 5001);
    }

    public function testTransferMoney(): void {
        $user1 = new User([
            'active' => 1,
            'balance' => 500,
        ]);
        $user2 = new User([
            'active' => 1,
            'balance' => 0,
        ]);

        User::transfer($user1, $user2, 300);

        $this->assertEquals(200, $user1->balance);
        $this->assertEquals(300, $user2->balance);
    }

    public function testCanBeOverdrawnByTransfer(): void {
        $user1 = new User([
            'active' => 1,
            'balance' => 0,
        ]);
        $user2 = new User([
            'active' => 1,
            'balance' => 0,
        ]);

        User::transfer($user1, $user2, 200);

        $this->assertEquals(-200, $user1->balance);
        $this->assertEquals(200, $user2->balance);
    }

    public function testCanNotBeOverdrawnOver200EurosByTransfer(): void {
        $user1 = new User([
            'active' => 1,
            'balance' => 0,
        ]);
        $user2 = new User([
            'active' => 1,
            'balance' => 0,
        ]);

        $this->expectException(InsufficientFundsException::class);

        User::transfer($user1, $user2, 201);
    }

    public function testCanNotTransferToInactiveAccount(): void {
        $user1 = new User([
            'active' => 1,
            'balance' => 0,
        ]);
        $user2 = new User([
            'active' => 0,
            'balance' => 0,
        ]);

        $this->expectException(AccountInactiveException::class);

        User::transfer($user1, $user2, 1000);
    }
}