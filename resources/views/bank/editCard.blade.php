@extends('app')

@section('content')

    <br><br>

    <div class="text-lg font-semibold text-bookmark-blue items-center mb-2 text-center">
        <span>Edit card details</span>
    </div>
    <br>

    <div class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200">
        <div class="flex flex-col justify-start">
            <div class="flex justify-between items-center w-96 pb-2">
                <div class="text-lg font-semibold text-bookmark-amber-600 flex space-x-1 items-center mb-2">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/ID-Card-icon.png"
                         class="inline-block w-5 h-5 mr-2"/>
                    <span class="pr-3">{{ $card->number }}</span>
                </div>
            </div>
            <div class="text-sm mb-2 font-semibold text-black flex space-x-1 items-center pb-2">
                <span>Owner: {{ Auth::user()->name }} {{ Auth::user()->lname }}</span>
            </div>
            <div class="text-sm font-semibold text-black flex space-x-1 items-center pb-2">
                <span>Current balance: {{ number_format($card->balance / 100, 2) }} {{ $card->currency }}</span>
            </div>

            <div class="text-sm font-semibold text-black flex space-x-1 items-center pb-2">
                <span>Add or withdraw balance: </span>
                <form action="/updateBalance" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="cardNumber" value="{{ $card->number }}">
                    <input class="border-4 rounded-md w-20 pl-3" type="text" name="amount"
                           placeholder="0.00"> {{ $card->currency }}
                    <button class="w-25 h-8 border-2 rounded-md" type="submit">Submit</button>
                </form>
            </div>

            <div class="text-sm font-semibold text-black flex space-x-1 items-center pb-2">
                <span>Change currency: </span>
                <form action="/changeCurrency" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="cardNumber" value="{{ $card->number }}">
                    <input type="hidden" name="action" value="changeCurrency">
                    <select class="border-4" name="currency">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" {{ $currency == $card->currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                    <button class="w-25 h-8 border-2 rounded-md" type="submit">Change</button>
                </form>
            </div>

            <div class="content-center">
                @if($errors->first())
                    <div
                        class="text-s text-red-600 font-semibold colored space-x-1 items-center pt-2 mb--2">
                        @foreach($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="content-center">
                @if (session('status'))
                    <div
                        class="text-s text-green-600 font-semibold colored space-x-1 items-center pt-2 mb--2">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <div>
                <div class="mt-5">
                    <form action="/deleteCard" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="cardNumber" value="{{ $card->number }}">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit"
                                class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-red-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                            Delete card
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
