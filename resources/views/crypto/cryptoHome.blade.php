@extends('app')

@section('content')

    <style>
        th, td {
            text-align: center;
            border: 1px solid #dddddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>

    <br><br>

    <div class="content">
        <div class="text-lg font-semibold text-bookmark-blue items-center mb-2 text-center">
            <span>Crypto Home</span>
        </div>

        <br>

        <div
            class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200 text-center content-center">
            <div class="flex-col justify-start">
                <div class="pb-2">
                    <div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div style="text-align: center;">

                                                <form action="/cryptoHome" method="get">

                                                    <select class="mt-2 ml-2 mr-2 border-2" name="account" id="accounts"
                                                            onchange="this.form.submit()">
                                                        @if (!request('account'))
                                                            <option value="" disabled selected>Select your account
                                                            </option>
                                                        @endif
                                                        @foreach ($accounts as $account)
                                                            <option
                                                                value="{{ $account->number }}" {{ request('account') == $account->number ? 'selected' : '' }}>{{ $account->number }}</option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </div>
                                            </form>
                                            @if (request('account'))

                                                <div class="text-lg font-semibold text-bookmark-blue items-center mb-2 mt-2">
                                                    <span>Balance and currency: {{ number_format($selectedAccount->balance / 100, 2) }} {{ $selectedAccount->currency }}</span>
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

                                                <div class="mt-3 mb-3" style="text-align: center;">
                                                    Show only owned coins:
                                                    <label class="switch">
                                                        <input type="checkbox" id="showOwnedCoinsCheckbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>


                                                <input
                                                    class="text-center w-50 text-md align-content-center px-3 py-2 rounded-lg w-60 mr-2 mb-2 mt-2 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                                                    placeholder="Search"
                                                    type="text"
                                                    id="search"
                                                    name="accfilter"
                                                >

                                                <div class="card-body">
                                                    <div class="card">
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>Icon</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th>Price change 1h</th>
                                                                <th>Price change 24h</th>
                                                                <th>You Own</th>
                                                                <th>

                                                                    <label class="text-amber-600">Validation
                                                                        code: {{ $verCode = mt_rand(1, 4) }}</label>
                                                                    <input
                                                                        class="text-center text-md align-content-center px-3 py-2 rounded-lg w-20 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
        focus:placeholder-gray-500 focus:bg-white focus:border-gray-600"
                                                                        type="text" name="userCode" placeholder="####"
                                                                        id="userCode" required>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($cryptoCollection->data as $index => $crypto)
                                                                <tr
                                                                    @if (isset($currentlyOwned[$crypto->symbol]) && !is_null($currentlyOwned[$crypto->symbol]) && $currentlyOwned[$crypto->symbol] > 0)
                                                                        class="owned"
                                                                    @endif
                                                                >
                                                                    <td>
                                                                        <img src="{{ $crypto->logo }}" width="26"
                                                                             height="26">
                                                                    </td>
                                                                    <td>{{ $crypto->name }} ({{ $crypto->symbol }})</td>
                                                                    <td>{{ number_format($crypto->quote->EUR->price, 2, ',', '.') }}
                                                                        EUR
                                                                    </td>
                                                                    <td>{{ number_format($crypto->quote->EUR->percent_change_1h, 2) }}
                                                                        %
                                                                    </td>
                                                                    <td>{{ number_format($crypto->quote->EUR->percent_change_24h, 2) }}
                                                                        %
                                                                    </td>
                                                                    <td>
                                                                        @if (!isset($currentlyOwned[$crypto->symbol]) || is_null($currentlyOwned[$crypto->symbol]))
                                                                            0
                                                                        @else
                                                                            {{ $currentlyOwned[$crypto->symbol] }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            style="display: flex; flex-direction: row; spacing: 20px">

                                                                            <input class="text-center text-md align-content-center px-3 py-2 rounded-lg w-20 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
        focus:placeholder-gray-500 focus:bg-white focus:border-gray-600" type="text" name="amount" placeholder="0"
                                                                                   id="inputField{{ $index }}">

                                                                            <form action="/cryptoHome/buy" method="post"
                                                                                  id="buyForm{{ $index }}">
                                                                                @csrf
                                                                                @method('post')
                                                                                <input type="hidden" name="amount"
                                                                                       id="inputFieldValueBuy{{ $index }}">
                                                                                <input type="hidden" name="name"
                                                                                       value="{{ $crypto->name }}">
                                                                                <input type="hidden" name="symbol"
                                                                                       value="{{ $crypto->symbol }}">
                                                                                <input type="hidden" name="num_from"
                                                                                       value="{{ request('account') }}">
                                                                                <input type="hidden" name="price"
                                                                                       value="{{ $crypto->quote->EUR->price }}">
                                                                                <input type="hidden" name="verCode"
                                                                                       value="{{ $verCode }}">
                                                                                <input type="hidden" name="userCode"
                                                                                       id="userCode">
                                                                            </form>

                                                                            <button class="mr-2 ml-2 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600
                                             hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer"
                                                                                    type="button"
                                                                                    onclick="submitBuyForm({{ $index }})">
                                                                                Buy
                                                                            </button>

                                                                            <form action="/cryptoHome/sell" method="post"
                                                                                  id="sellForm{{ $index }}">
                                                                                @csrf
                                                                                @method('post')
                                                                                <input type="hidden" name="amount"
                                                                                       id="inputFieldValueSell{{ $index }}">
                                                                                <input type="hidden" name="name"
                                                                                       value="{{ $crypto->name }}">
                                                                                <input type="hidden" name="symbol"
                                                                                       value="{{ $crypto->symbol }}">
                                                                                <input type="hidden" name="num_from"
                                                                                       value="{{ request('account') }}">
                                                                                <input type="hidden" name="price"
                                                                                       value="{{ $crypto->quote->EUR->price }}">
                                                                                <input type="hidden" name="verCode"
                                                                                       value="{{ $verCode }}">
                                                                                <input type="hidden" name="userCode"
                                                                                       id="userCode">
                                                                            </form>

                                                                            <button class="mr-2 ml-2 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600
                                             hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer"
                                                                                    type="button"
                                                                                    onclick="submitSellForm({{ $index }})">
                                                                                Sell
                                                                            </button>

                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                            @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                </div>
                                        </div>
                                        @endif

                                        <script>

                                            function filterTable() {
                                                // Get the values of the input fields
                                                var accfilter = document.getElementById('search').value;

                                                // Get the table rows
                                                var rows = document.querySelectorAll('table tbody tr');

                                                // Loop through the rows and hide those that don't match the filter
                                                for (var i = 0; i < rows.length; i++) {
                                                    var searchCell = rows[i].querySelector('td:nth-child(2)');

                                                    if (searchCell.textContent.toLowerCase().indexOf(accfilter.toLowerCase()) === -1) {
                                                        rows[i].style.display = 'none';
                                                    } else {
                                                        rows[i].style.display = '';
                                                    }
                                                }
                                            }

                                            document.getElementById('search').addEventListener('input', filterTable);


                                            document.querySelectorAll('tbody tr').forEach(function (row) {
                                                row.style.display = 'table-row';
                                            });

                                            document.getElementById('showOwnedCoinsCheckbox').addEventListener('click', function () {
                                                const ownedRows = document.querySelectorAll('.owned');
                                                if (this.checked) {
                                                    ownedRows.forEach(function (row) {
                                                        row.style.display = 'table-row';
                                                    });
                                                    document.querySelectorAll('tbody tr:not(.owned)').forEach(function (row) {
                                                        row.style.display = 'none';
                                                    });
                                                } else {
                                                    document.querySelectorAll('tbody tr').forEach(function (row) {
                                                        row.style.display = 'table-row';
                                                    });
                                                }
                                            });


                                            function submitBuyForm(index) {
                                                document.getElementById('inputFieldValueBuy' + index).value = document.getElementById('inputField' + index).value;
                                                document.getElementById('buyForm' + index).userCode.value = document.getElementById('userCode').value;
                                                document.getElementById('buyForm' + index).submit();
                                            }

                                            function submitSellForm(index) {
                                                document.getElementById('inputFieldValueSell' + index).value = document.getElementById('inputField' + index).value;
                                                document.getElementById('sellForm' + index).userCode.value = document.getElementById('userCode').value;
                                                document.getElementById('sellForm' + index).submit();
                                            }

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
