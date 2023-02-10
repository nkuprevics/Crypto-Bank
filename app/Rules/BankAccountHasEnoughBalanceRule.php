<?php

namespace App\Rules;

use App\Models\BankAccount;
use Illuminate\Contracts\Validation\Rule;

class BankAccountHasEnoughBalanceRule implements Rule
{

    public function passes($attribute, $value)
    {
        $amount = request('amount');

        if (!is_numeric($amount)) {
            $amount = 0;
        }

        $price = intval($amount * (request('price') * 100));
        $accountBalance = BankAccount::getBalance(request('num_from'));

        if ($price <= $accountBalance) {
            return true;
        } else {
            return false;
        }
    }

    public function message()
    {
        return 'Not enough balance.';
    }
}
