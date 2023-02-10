<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\CloseAccountRequest;
use App\Models\BankAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BankAccountsController extends Controller
{

    public function index(): View
    {
        return view('bank/accounts')
            ->with('data', BankAccount::where('owner_id', Auth::id())->get());
    }

    public function openAccount(): RedirectResponse
    {
        // validate request

        BankAccount::openNewAccount(Auth::id());

        return redirect('/accounts');
    }

    public function closeAccount(CloseAccountRequest $request): RedirectResponse
    {
        BankAccount::closeAccount($request['cardNumber']);

        return redirect('/accounts');
    }
}
