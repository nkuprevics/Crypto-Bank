<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\CloseAccountRequest;
use App\Models\BankAccount;
use App\Services\CurrencyConversionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EditCardController extends Controller
{
    private CurrencyConversionService $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }

    public function index(): View
    {
        if (!BankAccount::where('number', request('cardNumber'))->where('owner_id', Auth::id())->exists()) {
            abort(403);
        }

        return view('bank/editCard')
            ->with('card', BankAccount::selectByNumber(request('cardNumber')))
            ->with('currencies', $this->currencyConversionService->getAvailableCurrencies());
    }

    public function updateBalance(): RedirectResponse
    {
        request()->validate([
            'amount' => 'numeric|min:-' . BankAccount::getBalance(request('cardNumber')) / 100,
        ], [
            'amount.min' => "You can't withdraw more than you have",
        ]);

        BankAccount::updateBalance(request('cardNumber'), request('amount') * 100);

        return redirect("/editCard/" . request('cardNumber'))
            ->with('status', "You've successfully updated your balance");
    }

    public function changeCurrency(): RedirectResponse
    {
        $newBalance = $this->currencyConversionService->convert(
            BankAccount::getCurrency(request('cardNumber')),
            request('currency'),
            BankAccount::getBalance(request('cardNumber'))
        );

        BankAccount::setBalance(request('cardNumber'), $newBalance);

        BankAccount::changeCurrency(
            request('cardNumber'),
            request('currency')
        );

        return redirect("/editCard/" . request('cardNumber'))
            ->with('status', "You've successfully changed your currency");
    }

    public function deleteCard(CloseAccountRequest $request): RedirectResponse
    {
        BankAccount::closeAccount($request['cardNumber']);

        return redirect()->route('accounts');
    }
}
