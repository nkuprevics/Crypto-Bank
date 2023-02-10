<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'owner_id',
        'owner_name',
        'owner_lname',
        'number',
        'balance',
        'currency',
    ];

    public static function openNewAccount(int $owner_id):bool
    {
        $newAccount = (new BankAccount())->fill([
            'owner_id' => $owner_id,
            'owner_name' => User::getName($owner_id),
            'owner_lname' => User::getLastName($owner_id),
            'number' => "LV" . rand(111111111, 999999999),
            'balance' => 0,
            'currency' => "EUR",
        ]);

        CodeCard::create($newAccount->number);

        return $newAccount->save();
    }

    public static function closeAccount(string $cardNumber):bool
    {
        $codeCard = CodeCard::where('belongs_to', $cardNumber)->first();
        $codeCard->delete();

        $account = BankAccount::where('number', $cardNumber);

        return $account->delete();
    }

//    public static function selectAccount(int $id):object
//    {
//        return BankAccount::where('owner_id', $id)->get();
//    }

    public static function selectByNumber(string|null $number): object|null
    {
        return BankAccount::where('number', $number)->first();
    }

    public static function transactionHistory(string|null $from):object|null // todo maybe move to transaction model
    {
        $history = Transaction::where('num_from', $from)
            ->orWhere('num_to', $from)
            ->orderBy('created_at', 'desc')
            ->get();

        return $history;
    }

    public static function updateBalance(string $cardNumber, float $amount):bool
    {
        $account = BankAccount::where('number', $cardNumber)->first();

        $account->balance += $amount;

        return $account->save();
    }

    public static function setBalance(string $cardNumber, float $amount):bool
    {
        $account = BankAccount::where('number', $cardNumber)->first();

        $account->balance = $amount;

        return $account->save();
    }

    public static function changeCurrency(string $cardNumber, string $currency):bool
    {
        $account = BankAccount::where('number', $cardNumber)->first();

        $account->currency = $currency;

        return $account->save();
    }

//    public static function verifyCode(string $accountNumber, string $userInput, int $verificationCode):bool
//    {
//        $codeCard = CodeCard::where('belongs_to', $accountNumber)->first();
//
//        if ($codeCard->$verificationCode === (int) $userInput) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public static function getAccountNumbers($id)
    {
        return BankAccount::where('owner_id', $id)->pluck('number');
    }

    public static function getBalance(string $cardNumber):int
    {
        return BankAccount::where('number', $cardNumber)->first()->balance;
    }

    public static function getCurrency(string $cardNumber):string
    {
        return BankAccount::where('number', $cardNumber)->first()->currency;
    }

//    public static function checkIfAccountExists(string $name, string $lname, string $cardNumber):bool
//    {
//        $account = BankAccount::where('owner_name', $name)
//            ->where('owner_lname', $lname)
//            ->where('number', $cardNumber)
//            ->first();
//
//        if ($account) {
//            return true;
//        } else {
//            return false;
//        }
//    }
// todo get rid of this
}
