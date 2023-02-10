<?php

namespace App\Rules;

use App\Models\BankAccount;
use Illuminate\Contracts\Validation\Rule;

class AccountMustBeEmptyRule implements Rule
{

    public function passes($attribute, $value)
    {
        if (BankAccount::getBalance($value) / 100 > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function message()
    {
        return 'Bank account must be empty';
    }
}
