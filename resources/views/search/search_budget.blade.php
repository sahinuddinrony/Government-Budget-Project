@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 style="text-align: center;">Search Budget Between Fiscal Years</h2>

        <!-- Display the search form -->
        <form action="{{ route('search.searchBetweenFiscalYears') }}" method="GET">
            @csrf

            <div class="form-group">
                {{-- <label for="start_fiscal_year">Start Fiscal Year:</label>
                <input type="text" name="start_fiscal_year" id="start_fiscal_year" class="form-control" placeholder="Enter Start Fiscal Year" required> --}}


                <select id="start_fiscal_year" name="start_fiscal_year" required>
                    <option value="">--Select Fiscal Year--</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                </select>


                <select id="end_fiscal_year" name="end_fiscal_year" required>
                    <option value="">--Select Fiscal Year--</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                </select>

                {{-- <label for="end_fiscal_year">End Fiscal Year:</label>
                <input type="text" name="end_fiscal_year" id="end_fiscal_year" class="form-control" placeholder="Enter End Fiscal Year" required> --}}
            </div>
            {{-- <div class="form-group">
                <label for="end_fiscal_year">End Fiscal Year:</label>
                <input type="text" name="end_fiscal_year" id="end_fiscal_year" class="form-control" placeholder="Enter End Fiscal Year" required>
            </div> --}}
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Display the results only if budgets are set -->
        @if(isset($budgets))
            <h2 style="text-align: center;">Budget Summary Between Fiscal Years</h2>
            <table>
                <tr>
                    <td>ক্রমিক</td>
                    <td>অর্থনৈতিক কোড</td>
                    <td>ব্যয়ের খাত</td>
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
                        <td>{{ $loop->iteration }}</td>
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
            </table>
        @endif
    </div>
@endsection
