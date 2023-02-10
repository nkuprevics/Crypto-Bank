@extends('app')

@section('content')

    <br><br>

    <div class="content-center">

        <div class="text-lg font-semibold text-bookmark-blue items-center mb-2 text-center">
            <span>Transfer Money</span>
        </div>
        <br>

        <div
            class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200 text-center content-center">
            <div class="flex-col justify-start">


                <div class="pb-2">
                    <div>
                        <form action="/transfer" method="get">
                            <select class="border-2" name="account" id="accounts" onchange="this.form.submit()">
                                @if (!request('account'))
                                    <option value="" disabled selected>Select account to transfer from</option>
                                @endif
                                @foreach ($userAccounts as $account)
                                    <option
                                        value="{{ $account }}" {{ request('account') == $account ? 'selected' : '' }}>{{ $account }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="content-center">
                        @if (session('status'))
                            <div class="text-s text-green-600 font-semibold colored space-x-1 items-center pt-2 mb--2">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>

                </div>

                @if (request('account'))

                    <div class="text-lg font-semibold text-bookmark-blue items-center mb-2">
                        <span>Balance and currency: {{ number_format($selectedAccount->balance / 100, 2) }} {{ $selectedAccount->currency }}</span>
                    </div>

                    <div class="content-center">
                        @if($errors->first())
                            <div class="text-s text-red-600 font-semibold colored space-x-1 items-center pt-2 mb--2">
                                @foreach($errors->all() as $error)
                                    <span>{{ $error }}</span><br>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <form action="/transferMoney" method="post">
                        @csrf
                        @method('post')


                        <label>Name to:</label>
                        <br>
                        <input name="name_to" placeholder="First name" type="text"
                               class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                               required>
                        <br>
                        <label>Last name to:</label>
                        <br>
                        <input name="lname_to" placeholder="Last name" type="text"
                               class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                               required>
                        <br>
                        <label>Account to:</label>
                        <br>
                        <input name="num_to" placeholder="LV########" type="text"
                               class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                               required>
                        <br>
                        <label>Amount:</label>
                        <br>
                        <input name="amount_from" placeholder="10.00" type="text"
                               class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                               required>
                        <br>
                        <label>Comment (max 100 characters):</label>
                        <br>
                        <textarea name="comment" type="text"
                               class="px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                                  maxlength="100" required>
                        </textarea>
                        <br>
                        <label>Validation code: {{ $verCode = mt_rand(1, 4) }}</label>
                        <br>
                        <input name="userCode" placeholder="####" type="text"
                               class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                               required>

                        <input type="hidden" name="verCode" value="{{ $verCode }}">
                        <input type="hidden" name="num_from" id="selectedAccount"
                               value="{{ $selectedAccount->number }}">
                        <input type="hidden" name="currency_from" id="selectedAccount"
                               value="{{ $selectedAccount->currency }}">
                        <br>
                        <button type="submit"
                                class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600
                                 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded
                                  py-1 transition transform duration-200 cursor-pointer">
                            Transfer
                        </button>
                    </form>

                @endif

                <script>
                    // Get the select element
                    const selectElement = document.getElementById('accounts');

                    // Add an event listener for the 'change' event
                    selectElement.addEventListener('change', () => {
                        // Get the selected value
                        const selectedValue = selectElement.value;

                        // Set the value of the hidden input field
                        document.getElementById('selectedAccount').value = selectedValue;
                    });
                </script>
            </div>
        </div>
    </div>

@endsection
