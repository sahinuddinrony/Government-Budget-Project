<!DOCTYPE html>
<html>

<head>
    <title>Budget Details for Fiscal Year: {{ $fiscal_year }}</title>
    <style>
        /* body {
            font-family: 'solaimanlipi', sans-serif;
        } */

        body {
            font-family: 'bangla','Kalpurush', Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="text-align: center;">Budget Details for Fiscal Year: {{ $fiscal_year }}</h2>

        <h2>Show Details</h2>
        <table>
            <tr>
                <th>Serial No</th>
                <th>Item Name</th>
                <th>Allocation</th>
                <th>Expenditure</th>
                <th>Unused</th>
            </tr>

            @foreach ($budgets as $budget)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $budget->item_name }}</td>
                    <td>{{ $budget->allocation }}</td>
                    <td>{{ $budget->expenditure }}</td>
                    <td>{{ $budget->unused }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2" class="text-right"><strong>সর্বমোট =</strong></td>
                <td>{{ $budgets->sum('allocation') }}</td>
                <td>{{ $budgets->sum('expenditure') }}</td>
                <td>{{ $budgets->sum('unused') }}</td>
            </tr>

            <tr>
                <td colspan="4" class="text-right"><strong>চেক বই উত্তোলন=</strong></td>
                <td><strong>{{ $charges->sum('check_fee') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>ব্যাংক পরিচালনা ফিস=</strong></td>
                <td><strong>{{ $charges->sum('bank_charge') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>অব্যয়িত অর্থ ফেরত=</strong></td>
                <td><strong>{{ $charges->sum('unspent_refund') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>সর্বশেষ অব্যয়িত টাকা=</strong></td>
                <td>
                    <strong>
                        {{ $budgets->sum('unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund')) }}
                    </strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
