<?php

namespace App\Rules;

use App\Models\CodeCard;
use Illuminate\Contracts\Validation\Rule;

class CodeCardMatchRule implements Rule
{

    public function passes($attribute, $value)
    {
        $codeCard = CodeCard::where('belongs_to', request('num_from'))->first();

        $verificationCode = request('verCode');

        if ($codeCard->$verificationCode === (int) request('userCode')) {
            return true;
        } else {
            return false;
        }
    }

    public function message()
    {
        return 'The validation code is incorrect.';
    }
}
