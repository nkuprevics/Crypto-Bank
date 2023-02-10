<?php

namespace App\Rules;

use App\Models\BankAccount;
use Illuminate\Contracts\Validation\Rule;

class AccountExistsRule implements Rule
{

    public function passes($attribute, $value)
    {
        $account = BankAccount::where('owner_name', request('name_to'))
            ->where('owner_lname', request('lname_to'))
            ->where('number', $value)
            ->first();

        return $account !== null;
    }

    public function message()
    {
        return 'Receiving account does snot exist';
    }
}
