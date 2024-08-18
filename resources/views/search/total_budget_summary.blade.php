@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="button-container no-print">
            <button onclick="window.print()" class="btn btn-secondary">Print</button>
        </div>
        <br>
        {{-- <h2 style="text-align: center;">Budget Summary Across All Fiscal Years</h2> --}}
        <h2 style="text-align: center;">এক নজরে বাজেটের সারাং রিপোর্টের তথ্য</h2>
        <h2 style="text-align: center;">২০২০ - ২০২১ থেকে ২০২৪ - ২০২৫ অর্থ বছর</h2>
        <h2><a href="{{ route('budgets.index') }}" class="no-print">Back to List</a></h2>
        <table>
            {{-- <tr>
                <td>ক্রমিক</td>
                <td>অর্থনৈতিক কোড</td>
                <td>ব্যয়ের খাত</td>
                <td>মোট বরাদ্ধ</td>
                <td>মোট ব্যয়</td>
                <td>অব্যয়িত</td>
            </tr> --}}

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
                $groupedItems = $budgets->flatMap(function ($budget) {
                    return $budget->items;
                })->groupBy('item_name')->map(function ($items, $itemName) {
                    return [
                        'item_code' => $items->first()->item_code,
                        'item_allocation' => $items->sum('item_allocation'),
                        'item_expenditure' => $items->sum('item_expenditure'),
                        'item_unused' => $items->sum('item_unused'),
                    ];
                });

                $totalAllocation = $groupedItems->sum('item_allocation');
                $totalExpenditure = $groupedItems->sum('item_expenditure');
                $totalUnused = $groupedItems->sum('item_unused');
            @endphp

            @foreach ($groupedItems as $itemName => $item)
                <tr>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($loop->iteration) }}</td>
                    <td>{{ $item['item_code'] }}</td>
                    <td>{{ $itemName }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item['item_allocation']) }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item['item_expenditure']) }}</td>
                    <td>{{ \App\Helpers\NumberHelper::toBangla($item['item_unused']) }}</td>
                </tr>
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
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($finalUnused) }}</strong></td>
            </tr>
        </table>
    </div>
@endsection
