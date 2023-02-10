<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Transaction;

class MoneyTransactionService
{
    private CurrencyConversionService $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }

    public function transferMoney(array $validatedData): bool
    {
        $this->updateBalance(
            $validatedData['num_from'],
            $validatedData['num_to'],
            ($validatedData['amount_from'] * 100)
        );

        $this->registerTransaction($validatedData);

        return true;
    }

    private function updateBalance(string $sender, string $receiver, int $amount): bool
    {

        BankAccount::updateBalance($sender, -$amount);

        if (BankAccount::getCurrency($sender) !== BankAccount::getCurrency($receiver)) {
            $amount = $this->currencyConversionService->convert(
                BankAccount::getCurrency($sender),
                BankAccount::getCurrency($receiver),
                $amount
            );
        }

        return BankAccount::updateBalance($receiver, $amount);
    }

    private function registerTransaction(array $validatedData): bool
    {
        $sendingAccount = BankAccount::selectByNumber($validatedData['num_from']);
        $receivingAccount = BankAccount::selectByNumber($validatedData['num_to']);

        return Transaction::register([
            'name_from' => $sendingAccount->owner_name,
            'lname_from' => $sendingAccount->owner_lname,
            'amount_to' => ($validatedData['amount_from'] * 100),
            'currency_to' => $receivingAccount->currency,
        ]);
    }
}

