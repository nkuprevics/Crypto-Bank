<?php

namespace App\Http\Requests;

use App\Models\BankAccount;
use App\Rules\BankAccountHasEnoughBalanceRule;
use App\Rules\CodeCardMatchRule;
use Illuminate\Foundation\Http\FormRequest;

class CryptoBuyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userCode' => ['required', new CodeCardMatchRule()],
            'amount' => ['required', 'numeric', 'min:0' , new BankAccountHasEnoughBalanceRule()],
        ];
    }

    public function messages()
    {
        return [
            'userCode' => 'The validation code is incorrect.',
            'amount' => 'Not enough balance.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be greater than 0.',
        ];
    }
}
