<?php

namespace App\Http\Requests;

use App\Models\BankAccount;
use App\Rules\BankAccountHasEnoughBalanceRule;
use App\Rules\CodeCardMatchRule;
use App\Rules\UserMustOwnCryptoRule;
use Illuminate\Foundation\Http\FormRequest;

class CryptoSellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userCode' => ['required', new CodeCardMatchRule()],
            'amount' => ['required', 'numeric', new UserMustOwnCryptoRule()],
        ];
    }

    public function messages()
    {
        return [
            'userCode' => 'The validation code is incorrect.',
            'amount' => "You can't sell more than you own.",
            'amount.numeric' => 'The amount must be a number.',
        ];
    }
}
