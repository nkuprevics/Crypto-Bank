@extends('app')

@section('content')

    <br>

    <div
        class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200 cursor-pointer">
        <div class="flex flex-col justify-start">
            <div class="flex justify-between items-center w-96">
                <div class="text-lg font-semibold text-bookmark-amber-600 flex space-x-1 items-center mb-2">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/ID-Card-icon.png"
                         class="inline-block w-5 h-5 mr-2"/>
                    <span class="pr-3">Open New Account</span>
                    <span class="bg-amber-600 rounded-full uppercase text-white text-sm px-4 py-1 font-bold shadow-xl"> Available </span>

                </div>
            </div>
            <div class="text-sm text-gray-500 flex space-x-1 items-center">
                <span>Owner: {{ Auth::user()->name }} {{ Auth::user()->lname }}</span>
            </div>
            <div class="text-sm text-gray-500 flex space-x-1 items-center">
                <span>Number: to be generated</span>
            </div>
            <div>
                <div class="mt-5">
                    <form action="/openAccount" method="get">
                        @csrf
                        <button type="submit"
                                class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                            Open
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="text-lg font-semibold text-bookmark-blue flex space-x-1 items-center mb-2">
        <span>Current accounts</span>
    </div>

    <div class="content-center text-center">
        @if($errors->first())
            <div
                class="text-s text-red-600 font-semibold colored space-x-1 items-center pt-2 mb--2">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
        @endif
    </div>

    <br>

    @if ($data)
        @php($count=1)
        @foreach ($data as $account)

            <div
                class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200 cursor-pointer mb-5">
                <div class="flex flex-col justify-start">
                    <div class="flex justify-between items-center w-96">
                        <div class="text-lg font-semibold text-bookmark-blue flex space-x-1 items-center mb-2">
                            <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/ID-Card-icon.png"
                                 class="inline-block w-5 h-5 mr-2"/>
                            <span>{{ $account->number }}</span>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 flex space-x-1 items-center">
                        <span>Owner: {{ Auth::user()->name }} {{ Auth::user()->lname }}</span>
                    </div>
                    <div class="text-sm text-gray-500 flex space-x-1 items-center">
                        <span>Balance: {{ number_format($account->balance / 100, 2) }} {{ $account->currency }}</span>
                    </div>
                    <div>
                        <div class="mt-5" style="display: flex; text-align: center">
                            <form action="/transfer" method="get">
                                <input type="hidden" name="account" value="{{ $account->number }}">
                                <button type="submit" class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                    New Transaction
                                </button>
                            </form>
                            <form action="/history" method="get">
                                <input type="hidden" name="account" value="{{ $account->number }}">
                                <button type="submit" class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                    History
                                </button>
                            </form>
                            <form action="/editCard/{{ $account->number }}" method="get">
                                <button type="submit" class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                    Edit
                                </button>
                            </form>
                            <form action="/closeAccount" method="post">
                                @method('delete')
                                <input type="hidden" name="cardNumber" value="{{ $account->number }}">
                                <button type="submit" class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-red-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                    Close Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif
@endsection
