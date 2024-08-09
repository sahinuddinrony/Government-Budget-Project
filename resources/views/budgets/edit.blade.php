@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="button-container no-print">
            <a href="{{ route('budgets.show', $budget->id) }}" class="btn btn-secondary">Back to Details</a>
        </div>
        <br>
        <h2 style="text-align: center;">Edit Budget for Fiscal Year: {{ $budget->fiscal_year }}</h2>

        <form action="{{ route('budgets.update', $budget->id) }}" method="POST" oninput="updateCalculations()">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fiscal_year">Fiscal Year</label>
                <input type="text" name="fiscal_year" id="fiscal_year" class="form-control" value="{{ old('fiscal_year', $budget->fiscal_year) }}" required>
            </div>

            <table>
                <tr>
                    <td>Serial No</td>
                    <td>Economic Code</td>
                    <td>Expense Head</td>
                    <td>Total Allocation</td>
                    <td>Total Expenditure</td>
                    <td>Unused</td>
                </tr>
                @foreach ($budget->items as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <input type="text" name="items[{{ $index }}][item_code]" class="form-control" value="{{ old('items.'.$index.'.item_code', $item->item_code) }}" required>
                        </td>
                        <td>
                            <input type="text" name="items[{{ $index }}][item_name]" class="form-control" value="{{ old('items.'.$index.'.item_name', $item->item_name) }}" required>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][item_allocation]" class="form-control allocation" value="{{ old('items.'.$index.'.item_allocation', $item->item_allocation) }}" required>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][item_expenditure]" class="form-control expenditure" value="{{ old('items.'.$index.'.item_expenditure', $item->item_expenditure) }}" required>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][item_unused]" class="form-control unused" value="{{ old('items.'.$index.'.item_unused', $item->item_unused) }}" readonly>
                        </td>
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>সর্বমোট =</strong></td>
                    <td id="total_allocation">{{ \App\Helpers\NumberHelper::toBangla($budget->items->sum('item_allocation')) }}</td>
                    <td id="total_expenditure">{{ \App\Helpers\NumberHelper::toBangla($budget->items->sum('item_expenditure')) }}</td>
                    <td id="total_unused">{{ \App\Helpers\NumberHelper::toBangla($budget->items->sum('item_unused')) }}</td>
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
                    <td id="final_unused">
                        <strong>
                            {{ \App\Helpers\NumberHelper::toBangla($budget->items->sum('item_unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund'))) }}
                        </strong>
                    </td>
                </tr>
            </table>

            <button type="submit" class="btn btn-primary">Update Budget</button>
        </form>
    </div>

    <script>
        function updateCalculations() {
            let totalAllocation = 0;
            let totalExpenditure = 0;
            let totalUnused = 0;

            document.querySelectorAll('input.allocation').forEach((element, index) => {
                const allocation = parseFloat(element.value) || 0;
                const expenditure = parseFloat(document.querySelectorAll('input.expenditure')[index].value) || 0;
                const unused = allocation - expenditure;

                document.querySelectorAll('input.unused')[index].value = unused;

                totalAllocation += allocation;
                totalExpenditure += expenditure;
                totalUnused += unused;
            });

            const checkFee = parseFloat("{{ $charges->sum('check_fee') }}") || 0;
            const bankCharge = parseFloat("{{ $charges->sum('bank_charge') }}") || 0;
            const unspentRefund = parseFloat("{{ $charges->sum('unspent_refund') }}") || 0;

            const finalUnused = totalUnused - (checkFee + bankCharge + unspentRefund);

            document.getElementById('total_allocation').textContent = toBangla(totalAllocation);
            document.getElementById('total_expenditure').textContent = toBangla(totalExpenditure);
            document.getElementById('total_unused').textContent = toBangla(totalUnused);
            document.getElementById('final_unused').textContent = toBangla(finalUnused);
        }

        function toBangla(num) {
            const banglaNumbers = {0: '০', 1: '১', 2: '২', 3: '৩', 4: '৪', 5: '৫', 6: '৬', 7: '৭', 8: '৮', 9: '৯'};
            return num.toString().split('').map(n => banglaNumbers[n] || n).join('');
        }
    </script>
@endsection
