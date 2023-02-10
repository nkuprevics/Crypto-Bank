<?php

namespace App\Http\Requests;

use App\Rules\AccountMustBeEmptyRule;
use Illuminate\Foundation\Http\FormRequest;

class CloseAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cardNumber' => ['required', new AccountMustBeEmptyRule()],
        ];
    }

    public function messages()
    {
        return [
            'cardNumber' => 'Bank account must be empty',
        ];
    }
}
