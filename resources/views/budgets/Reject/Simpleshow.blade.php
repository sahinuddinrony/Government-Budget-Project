@extends('layouts.app')

@section('content')
    <div class="container">


        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="button-container no-print">
            <a href="{{ route('budgets.pdf', $budget->id) }}" class="btn btn-primary">Download PDF</a>
            <button onclick="window.print()" class="btn btn-secondary">Print</button>
        </div>
        <br>
        <h2 style="text-align: center;">Budget Details for Fiscal Year: {{ $fiscal_year }}</h2>
        <h2><a href="{{ route('budgets.index') }}">Back to List</a></h2>
        <table>
            {{-- <tr>
                <th>Serial No</th>
                <th>Item Name</th>
                <th>Allocation</th>
                <th>Expenditure</th>
                <th>Unused</th>
            </tr> --}}

            <tr>
                <td rowspan="2">ক্রমিক</td>
                <td rowspan="2">অর্থনৈতিক কোড</td>
                <td rowspan="2">ব্যয়ের খাত</td>
                <td colspan="3">বরাদ্ধ / ব্যয়ের হিসাব
                </td>
            </tr>
            <tr>
                <td>মোট বরাদ্ধ</td>
                <td>মোট ব্যয়</td>
                <td>অব্যয়িত</td>
            </tr>


            @foreach ($budgets as $index => $budget)
                @foreach ($budget->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- <td style="text-align: left;">
                        @foreach ($budget->items as $item)
                            {{ $item->item_name }}<br>
                        @endforeach
                    </td> --}}
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
                <td>{{ \App\Helpers\NumberHelper::toBangla($budgets->sum('allocation')) }}</td>
                <td>{{ \App\Helpers\NumberHelper::toBangla($budgets->sum('expenditure')) }}</td>
                <td>{{ \App\Helpers\NumberHelper::toBangla($budgets->sum('unused')) }}</td>
            </tr>

            <tr>
                <td colspan="4" class="text-right"><strong>চেক বই উত্তোলন=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($charges->sum('check_fee')) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>ব্যাংক পরিচালনা ফিস=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($charges->sum('bank_charge')) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>অব্যয়িত অর্থ ফেরত=</strong></td>
                <td><strong>{{ \App\Helpers\NumberHelper::toBangla($charges->sum('unspent_refund')) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>সর্বশেষ অব্যয়িত টাকা=</strong></td>
                <td>
                    <strong>
                        {{ \App\Helpers\NumberHelper::toBangla($budgets->sum('unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund'))) }}
                    </strong>
                </td>
            </tr>
        </table>
    </div>
@endsection
