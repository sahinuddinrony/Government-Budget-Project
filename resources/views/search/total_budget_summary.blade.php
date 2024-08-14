@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="button-container no-print">
            {{-- <a href="{{ route('budgets.pdf', $budget->id) }}" class="btn btn-primary">Download PDF</a> --}}
            <button onclick="window.print()" class="btn btn-secondary">Print</button>
        </div>
        <br>
        <h2 style="text-align: center;">Budget Details for Fiscal Year: {{ $fiscal_year }}</h2>
        <h2><a href="{{ route('budgets.index') }}">Back to List</a></h2>
        <table>
            <tr>
                <td rowspan="2">ক্রমিক</td>
                <td rowspan="2">অর্থনৈতিক কোড</td>
                <td rowspan="2">ব্যয়ের খাত</td>
                <td colspan="3">বরাদ্ধ / ব্যয়ের হিসাব</td>
            </tr>
            <tr>
                <td>মোট বরাদ্ধ</td>
                <td>মোট ব্যয়</td>
                <td>অব্যয়িত</td>
            </tr>

            @php
                $totalAllocation = 0;
                $totalExpenditure = 0;
                $totalUnused = 0;
            @endphp

            @foreach ($budgets as $index => $budget)
                @foreach ($budget->items as $item)
                @php
                    $totalAllocation += $item->item_allocation;
                    $totalExpenditure += $item->item_expenditure;
                    $totalUnused += $item->item_unused;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item->item_allocation) }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item->item_expenditure) }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item->item_unused) }}</td>
                </tr>
                @endforeach
            @endforeach

            <tr>
                <td colspan="3" class="text-right"><strong>সর্বমোট =</strong></td>
                <td>{{ \App\Helpers\NumberHelper::toBangla($totalAllocation) }}</td>
                <td>{{ \App\Helpers\NumberHelper::toBangla($totalExpenditure) }}</td>
                <td>{{ \App\Helpers\NumberHelper::toBangla($totalUnused) }}</td>
            </tr>

            @php
                $checkFeeTotal = $charges->sum('check_fee');
                $bankChargeTotal = $charges->sum('bank_charge');
                $unspentRefundTotal = $charges->sum('unspent_refund');
                $finalUnused = $totalUnused - ($checkFeeTotal + $bankChargeTotal + $unspentRefundTotal);
            @endphp

            <tr>
                <td colspan="4" class="text-right"><strong>চেক বই উত্তোলন=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($checkFeeTotal) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>ব্যাংক পরিচালনা ফিস=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($bankChargeTotal) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>অব্যয়িত অর্থ ফেরত=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($unspentRefundTotal) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>সর্বশেষ অব্যয়িত টাকা=</strong></td>
                <td>
                    <strong>{{ \App\Helpers\NumberHelper::toBangla($finalUnused) }}</strong>
                </td>
            </tr>
        </table>
    </div>
@endsection
