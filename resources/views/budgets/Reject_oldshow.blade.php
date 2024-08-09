@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 style="text-align: center;">Budget Details for Fiscal Year: {{ $fiscal_year }}</h2>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <br>

        <a href="{{ route('budgets.index') }}">Back to List</a>
        <br><br>

        <h2>Show Details</h2>
        <table>
            <tr>
                <th>Serial No</th>
                <th>Item Name</th>
                <th>Allocation</th>
                <th>Expenditure</th>
                <th>Unused</th>
            </tr>

            @foreach($budgets as $budget)
            {{-- <h2 style="text-align: center;">Budget Details for Fiscal Year: {{ $budget->fiscal_year }}</h2> --}}
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $budget->item_name }}</td>
                    <td>{{ $budget->allocation }}</td>
                    <td>{{ $budget->expenditure }}</td>
                    <td>{{ $budget->unused }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2" class="text-right"><strong>Total</strong></td>
                <td>{{ $budgets->sum('allocation') }}</td>
                <td>{{ $budgets->sum('expenditure') }}</td>
                <td>{{ $budgets->sum('unused') }}</td>
            </tr>

            {{-- @php
            $totalCheckFee = 0;
            $totalBankCharge = 0;
            $totalUnspentRefund = 0;
            $lastUnspentRefund = 0;

            foreach ($budgets as $budget) {
                foreach ($budget->charges as $charge) {
                    $totalCheckFee += $charge->check_fee;
                    $totalBankCharge += $charge->bank_charge;
                    $totalUnspentRefund += $charge->unspent_refund;
                    $lastUnspentRefund = $charge->unspent_refund;
                }
            }
        @endphp
        <td><strong>{{ $totalCheckFee }}</strong></td>
        --}}

        {{-- @dd($budgets->charges); --}}
        @foreach($budgets as $budget)
        @foreach ($budget->charges as $charge)
        <tr>
            <td colspan="4" class="text-right"><strong>চেক বই উত্তোলন=</strong></td>
            <td><strong>{{ $charge->check_fee }}</strong></td>
        </tr>
        @endforeach
    <!-- Display other details of the budget here -->

@endforeach

            {{-- <tr>
                <td colspan="4" class="text-right"><strong>চেক বই উত্তোলন=</strong></td>
                <td><strong>{{ $budgets->charges->pluck('check_fee') }}</strong></td>
            </tr> --}}
            {{-- <tr>
                <td colspan="4" class="text-right"><strong>ব্যাংক পরিচালনা ফিস=</strong></td>
                <td><strong>{{ $budgets->flatMap->charges->sum('bank_charge') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>অব্যয়িত অর্থ ফেরত=</strong></td>
                <td><strong>{{ $budgets->flatMap->charges->sum('unspent_refund') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>সর্বশেষ অব্যয়িত টাকা=</strong></td>
                <td><strong>{{ $budgets->flatMap->charges->last()->unspent_refund ?? 0 }}</strong></td>
            </tr> --}}
        </table>
    </div>
@endsection
