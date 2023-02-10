<?php

namespace App\Rules;

use App\Models\CryptoInventory;
use Illuminate\Contracts\Validation\Rule;

class UserMustOwnCryptoRule implements Rule
{
    public function passes($attribute, $value)
    {
        $amount = request('amount');
        if (!is_numeric($amount)) {
            $amount = 0;
        }

        $inventory = CryptoInventory::getInventory(request('num_from'));

        if (!array_key_exists(request('symbol'), $inventory)) {
            return false;
        }

        if ($amount <= $inventory[request('symbol')]) {
            return true;
        } else {
            return false;
        }
    }


    public function message()
    {
        return "Can't sell more than you own.";
    }
}
