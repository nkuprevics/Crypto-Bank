<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Http\Requests\CryptoBuyRequest;
use App\Http\Requests\CryptoSellRequest;
use App\Models\BankAccount;
use App\Models\CryptoInventory;
use App\Models\CryptoTransaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoHomeController extends Controller
{
    public function index(): View
    {
        return view('crypto/cryptoHome')
            ->with('accounts', User::find(Auth::id())->bankAccounts)
            ->with('selectedAccount', BankAccount::selectByNumber(request('account')))
            ->with('cryptoCollection', CryptoInventory::getCryptoCollection(25))
            ->with('currentlyOwned', CryptoInventory::getInventory(request('account')));
    }

    public function buy(CryptoBuyRequest $request): RedirectResponse
    {
        BankAccount::updateBalance(
            $request['num_from'],
            (-$request['price'] * 100)
        );

        CryptoTransaction::register([
            'bank_account' => $request['num_from'],
            'name' => $request['name'],
            'symbol' => $request['symbol'],
            'amount' => $request['amount'],
            'price' => $request['price'],
            'date' => now()->addHours(2)
        ]);

        CryptoInventory::storeTransaction
        (
            $request['num_from'],
            $request['symbol'],
            $request['amount'],
        );

        return redirect("/cryptoHome?account={$request['num_from']}")
            ->with('status', "You've successfully bought {$request['amount']} {$request['symbol']}");
    }

    public function sell(CryptoSellRequest $request): RedirectResponse
    {
        BankAccount::updateBalance(
            $request['num_from'],
            ($request['price'] * 100)
        );

        CryptoTransaction::register([
            'bank_account' => $request['num_from'],
            'name' => $request['name'],
            'symbol' => $request['symbol'],
            'amount' => ($request['amount'] * -1),
            'price' => $request['price'],
            'date' => now()->addHours(2)
        ]);

        CryptoInventory::storeTransaction(
            $request['num_from'],
            $request['symbol'],
            ($request['amount'] * -1),
        );

        return redirect("/cryptoHome?account={$request['num_from']}")
            ->with('status', "You've successfully sold {$request['amount']} {$request['symbol']}");
    }
}
