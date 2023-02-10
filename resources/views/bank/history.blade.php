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

        form {
            width: 50%;
            margin: 0 auto;
        }
    </style>

    <br><br>

    <div class="content">

        <div class="text-lg font-semibold text-bookmark-blue items-center mb-2 text-center">
            <span>Transaction History</span>
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
                                                <form action="/history" method="get">
                                                    <select class="mt-2 ml-2 mr-2 border-2" name="account"
                                                            onchange="this.form.submit()">
                                                        @if (!request('account'))
                                                            <option value="" disabled selected>Select your account
                                                            </option>
                                                        @endif
                                                        @foreach ($userAccounts as $account)
                                                            <option
                                                                    value="{{ $account }}" {{ request('account') == $account ? 'selected' : '' }}>{{ $account }}</option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                                <br>

                                                @if (request('account'))
                                                    <form action="/filterDate" method="get">
                                                        @csrf
                                                        <label for="start_date">Filter date</label>
                                                        <br>
                                                        <input class="mb-2 mt-2 ml-1 mr-1 border-4" type="date"
                                                               name="start_date" id="start_date"
                                                               max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                               required>
                                                        <input class="mb-2 mt-2 ml-1 mr-1 border-4" type="date"
                                                               name="end_date" id="end_date"
                                                               max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                               required>

                                                        <input hidden="hidden" name="account"
                                                               value="{{ request('account') }}">
                                                        <br>
                                                        <button class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600
                                 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded
                                  py-1 transition transform duration-200 cursor-pointer" type="submit">Filter
                                                        </button>
                                                        <br>
                                                    </form>
                                            </div>

                                            <div style="display: flex;">
                                                <input
                                                        class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 mr-2 mb-2 mt-2 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                                                        placeholder="Account Number" type="text" id="accfilter"
                                                        name="accfilter"
                                                        style="flex: 1;">
                                                <input
                                                        class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 mr-2 mb-2 mt-2 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                                                        placeholder="Name" type="text" id="name" name="name"
                                                        style="flex: 1;">
                                                <input
                                                        class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 mr-2 mb-2 mt-2 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
                                                        placeholder="Last Name" type="text" id="last_name"
                                                        name="last_name"
                                                        style="flex: 1;">
                                            </div>

                                            <table style="border-collapse: collapse; width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Account number</th>
                                                    <th>Name and Last name</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($history as $transfer)
                                                    <tr>
                                                        <td>
                                                            @if ($transfer->num_to === $currentSelection->number)
                                                                Received
                                                            @else
                                                                Sent
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($transfer->num_to === $currentSelection->number)
                                                                {{ $transfer->num_from }}
                                                            @else
                                                                {{ $transfer->num_to }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($transfer->num_to === $currentSelection->number)
                                                                {{ $transfer->name_from }} {{ $transfer->lname_from }}
                                                            @else
                                                                {{ $transfer->name_to }} {{ $transfer->lname_to }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($transfer->num_to === $currentSelection->number)
                                                                {{ number_format($transfer->amount_to / 100, 2) }} {{ $transfer->currency_to }}
                                                            @else
                                                                {{ number_format($transfer->amount_from / 100, 2) }} {{ $transfer->currency_from }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $transfer->created_at }}</td>
                                                        <td>{{ $transfer->comment }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>


                                            @endif
                                            <script>
                                                function filterTable() {
                                                    // Get the values of the input fields
                                                    var accfilter = document.getElementById('accfilter').value;
                                                    var name = document.getElementById('name').value;
                                                    var lastName = document.getElementById('last_name').value;

                                                    // Get the table rows
                                                    var rows = document.querySelectorAll('table tbody tr');

                                                    // Loop through the rows and hide those that don't match the filter
                                                    for (var i = 0; i < rows.length; i++) {
                                                        var accfilterCell = rows[i].querySelector('td:nth-child(2)');
                                                        var nameCell = rows[i].querySelector('td:nth-child(3)');
                                                        var lastNameCell = rows[i].querySelector('td:nth-child(3)');

                                                        if (accfilterCell.textContent.toLowerCase().indexOf(accfilter.toLowerCase()) === -1 || nameCell.textContent.toLowerCase().indexOf(name.toLowerCase()) === -1 || lastNameCell.textContent.toLowerCase().indexOf(lastName.toLowerCase()) === -1) {
                                                            rows[i].style.display = 'none';
                                                        } else {
                                                            rows[i].style.display = '';
                                                        }
                                                    }
                                                }

                                                document.getElementById('accfilter').addEventListener('input', filterTable);
                                                document.getElementById('name').addEventListener('input', filterTable);
                                                document.getElementById('last_name').addEventListener('input', filterTable);

                                                // Get the start date and end date input elements
                                                const startDateInput = document.getElementById('start_date');
                                                const endDateInput = document.getElementById('end_date');

                                                // Add an event listener for the 'change' event on the start date input
                                                startDateInput.addEventListener('change', () => {
                                                    // Set the minimum value for the end date input to the selected start date
                                                    endDateInput.min = startDateInput.value;

                                                    // Set the maximum value for the end date input to one year after the selected start date
                                                    endDateInput.max = new Date(new Date(startDateInput.value).getTime() + (365 * 24 * 60 * 60 * 1000)).toISOString().split('T')[0];
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection
