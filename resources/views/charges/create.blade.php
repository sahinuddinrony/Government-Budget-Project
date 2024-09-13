@extends('layouts.app')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">

            <!-- Left side menu -->
            <div class="w-1/4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-800">Menu</h3>
                        <div class="mt-4">
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('budgets.index') }}"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        সব বাজেটের তালিকা
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('charges.index') }}"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        ব্যাংক চার্জের তথ্য
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-button">
                                            বাজেট রিপোর্ট
                                            <i class="fas fa-chevron-down ml-2"></i>
                                        </button>
                                        <div class="dropdown-list">
                                            <a href="{{ route('search.showSearchForm') }}">অর্থবছর ভিত্তিক সাঃ রিপোর্ট</a>
                                            <a href="{{ route('search.summary') }}">বাজেটের সারাংশ রিপোর্ট</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                </br>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>মোট অব্যয়িত অর্থ (কোন কর্তন ছাড়া):</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="unspent_money" name="unspent_money" class="form-control"
                            placeholder="Unspent Money" readonly>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>ব্যাংক বাবদ মোট খরচ:</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="total_expenditure" name="total_expenditure" class="form-control"
                            placeholder="Total Bank Expenditure" readonly>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>মোট স্থিতি অর্থ (যাহা অব্যয়িত অর্থ হিসাবে ফেরত দিতে
                            হবে):</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="total_balance" name="total_balance" class="form-control"
                            placeholder="Total Balance" readonly>
                    </div>
                </div>
                </br>
            </div>

            <div class="container">
                <h2 class="col-xs-12 col-sm-12 col-md-12 text-center">অর্থবছর ভিত্তিক ব্যাংক চার্জের তথ্য | নতুন যোগ করুন
                </h2>
                </br>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('charges.store') }}" method="POST" class="form-horizontal">
                    @csrf

                    @if (auth()->user()->isAdmin())
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>Budget Item:</strong></label>
                            <div class="col-sm-10">
                                <select name="budget_id" class="form-control" required>
                                    @foreach ($budgets as $budget)
                                        <option value="{{ $budget->id }}">{{ $budget->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </br>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><strong>User:</strong></label>
                            <div class="col-sm-10">
                                <select name="user_id" class="form-control" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </br>
                    @else
                        <!-- Hidden budget_id input field for non-admin users -->
                        <input type="hidden" name="budget_id" value="{{ old('budget_id', $budgets->first()->id ?? '') }}">
                    @endif

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>অর্থবছর:</strong></label>
                        <div class="col-sm-10">
                            <select name="fiscal_year" id="fiscal_year" class="form-control" onchange="fetchUnspentMoney()">
                                <option value="">--Select Fiscal Year--</option>
                                @foreach ($fiscalYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>চেক বই বাবদ খরচ:</strong></label>
                        <div class="col-sm-10">
                            <input type="number" id="check_fee" name="check_fee" class="form-control"
                                placeholder="Check Fee" oninput="calculateTotalExpenditure()">
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>ব্যাংক চার্জ বাবদ খরচ:</strong></label>
                        <div class="col-sm-10">
                            <input type="number" id="bank_charge" name="bank_charge" class="form-control"
                                placeholder="Bank Charge" oninput="calculateTotalExpenditure()">
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>অব্যয়িত অর্থ ফেরত:</strong></label>
                        <div class="col-sm-10">
                            <input type="number" name="unspent_refund" class="form-control" placeholder="Unspent Refund">
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><strong>হস্তে মজুদ অথবা ব্যাংকে অবশিষ্ট অব্যয়িত
                                অর্থ:</strong></label>
                        <div class="col-sm-10">
                            <input type="number" name="unspent_money" class="form-control"
                                placeholder="Hand Unspent Money">
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-left">
                            <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                            <button type="reset" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                </form>
                {{-- </br>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>মোট অব্যয়িত অর্থ (কোন কর্তন ছাড়া):</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="unspent_money" name="unspent_money" class="form-control"
                            placeholder="Unspent Money" readonly>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>ব্যাংক বাবদ মোট খরচ:</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="total_expenditure" name="total_expenditure" class="form-control"
                            placeholder="Total Bank Expenditure" readonly>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><strong>মোট স্থিতি অর্থ (যাহা অব্যয়িত অর্থ হিসাবে ফেরত দিতে
                            হবে):</strong></label>
                    <div class="col-sm-10">
                        <input type="number" id="total_balance" name="total_balance" class="form-control"
                            placeholder="Total Balance" readonly>
                    </div>
                </div>
                </br> --}}

            </div>
        </div>
    </div>

    <script>
        function fetchUnspentMoney() {
            const fiscalYear = document.getElementById('fiscal_year').value;

            if (fiscalYear) {
                $.ajax({
                    url: '{{ route('get.unspent.money') }}',
                    type: 'GET',
                    data: {
                        fiscal_year: fiscalYear
                    },
                    success: function(response) {
                        document.getElementById('unspent_money').value = response.unspent_money;
                        calculateTotalExpenditure(); // Recalculate total balance after fetching unspent money
                    },
                    error: function(xhr) {
                        console.error("Error fetching unspent money:", xhr);
                    }
                });
            }
        }

        function calculateTotalExpenditure() {
            const checkFee = parseFloat(document.getElementById('check_fee').value) || 0;
            const bankCharge = parseFloat(document.getElementById('bank_charge').value) || 0;
            const unspentMoney = parseFloat(document.getElementById('unspent_money').value) || 0;

            const totalExpenditure = checkFee + bankCharge;
            document.getElementById('total_expenditure').value = totalExpenditure.toFixed(2);

            const totalBalance = unspentMoney - totalExpenditure;
            document.getElementById('total_balance').value = totalBalance.toFixed(2);
        }
    </script>

@endsection
