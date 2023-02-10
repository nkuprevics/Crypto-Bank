<?php

namespace App\Http\Requests;

use App\Models\BankAccount;
use App\Models\CodeCard;
use App\Rules\AccountExistsRule;

use App\Rules\CodeCardMatchRule;
use Illuminate\Foundation\Http\FormRequest;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class MoneyTransactionRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_to' => 'string|regex:/^[A-Za-z ]+$/',
            'lname_to' => 'string|regex:/^[A-Za-z ]+$/',
            'num_to' => ['required', new AccountExistsRule()],
            'amount_from' => 'numeric|lte:' . BankAccount::getBalance(request('num_from')) / 100,
            'userCode' => ['required', new CodeCardMatchRule()],
            ];
    }

    public function messages()
    {
        return [
            'name_to' => 'The name field must contain only letters.',
            'lname_to' => 'The last name field must contain only letters.',
            'num_to' => 'The receiving account does not exist.',
            'amount_from' => 'The amount must be less than or equal to the balance of your account.',
            'userCode' => 'The validation code is incorrect.',
        ];
    }
}
