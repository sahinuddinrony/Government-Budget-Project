

// namespace App\Http\Controllers;


// use App\Models\Budget;
// use App\Models\Charge;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use PDF;

// class PDFController extends Controller
// {
//     public function downloadPDF(Budget $budget)
//     {
//         // echo "PDF";

//         $userId = auth()->id();

//         // Retrieve budgets for the authenticated user and the selected fiscal year
//         $budgets = Budget::where('user_id', $userId)
//             ->where('fiscal_year', $budget->fiscal_year)
//             ->get();

//         if ($budgets->isEmpty()) {
//             return redirect()->route('budgets.index')->with('error', 'No budgets found for the selected fiscal year.');
//         }

//         // Retrieve charges related to the budgets for the selected fiscal year
//         $charges = Charge::where('user_id', $userId)
//             ->where('fiscal_year', $budget->fiscal_year)
//             ->get();

//         $fiscal_year = $budget->fiscal_year;

//         $pdf = PDF::loadView('budgets.pdf', compact('budgets', 'charges', 'fiscal_year', 'budget'));
//         return $pdf->download('budget-details.pdf');
//     }
// }


<!DOCTYPE html>
<html>

<head>
    <title>Budget Details for Fiscal Year: {{ $fiscal_year }}</title>
    <meta charset="UTF-8">
    <style>
        /* @font-face {
            font-family: 'BanglaFont';
            src: url('{{ asset('fonts/Nikosh.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
            font-embed: active;
            font-embed-allowed-origins: self;
        }

        body {
            font-family: 'BanglaFont', sans-serif;
        } */

        @font-face {
            font-family: 'BanglaFont';
            src: url('{{ asset('fonts/Nikosh.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'BanglaFont', sans-serif;
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
                <td colspan="2" class="text-right"><strong>Total</strong></td>
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
