Step-by-Step Instructions for Organizing Files and Assets in a Laravel Project
Step 1: Create the Blade Layout and Index Views
1. Create the Main Layout File
Create a file resources/views/layouts/app.blade.php with the following content:

blade.php
Copy code
<!DOCTYPE html>
<html>
<head>
    <title>Budget Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
2. Create the Index View
Create a file resources/views/budgets/index.blade.php with the following content:

blade.php
Copy code
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Information Input Table</h2>

    @if ($message = Session::get('success'))
        <div class="success-message">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form id="item-form" action="{{ route('budgets.store') }}" method="POST">
        @csrf

        <td>
            <select id="item1" name="fiscal_year">
                <option value="">--Fiscal Year--</option>
                <option value="2020-2021">2020-2021</option>
                <option value="2021-2022">2021-2022</option>
                <option value="2022-2023">2022-2023</option>
                <option value="2024-2025">2024-2025</option>
            </select>
        </td>

        <table id="item-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Item Name</th>
                    <th>Allocation</th>
                    <th>Expenditure</th>
                    <th>Unused</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="hidden" name="item_name[]" value="Computer">Computer</td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><input type="hidden" name="item_name[]" value="Salary">Salary</td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><input type="hidden" name="item_name[]" value="House Rent">House Rent</td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><input type="hidden" name="item_name[]" value="Current Bill">Current Bill</td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td id="total-allocation">0</td>
                    <td id="total-expenditure">0</td>
                    <td id="total-unused">0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <button type="button" id="add-row">Add Row</button>
        <button type="submit">Submit</button>
        <button type="reset">Clear</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endsection
Step 2: Add CSS and JavaScript Files
1. Create CSS File
Create a file public/css/app.css with the following content:

css
Copy code
body {
    font-family: Arial, sans-serif;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
}

.actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.actions form {
    display: inline;
}

.success-message {
    color: green;
    margin-bottom: 20px;
    text-align: center;
}

.text-right {
    text-align: right;
}

.remove-row {
    cursor: pointer;
    color: red;
}
2. Create JavaScript File
Create a file public/js/app.js with the following content:

javascript
Copy code
$(document).ready(function() {
    function updateTotals() {
        let totalAllocation = 0;
        let totalExpenditure = 0;
        let totalUnused = 0;

        $('#item-table tbody tr').each(function() {
            const allocation = parseFloat($(this).find('.allocation').val()) || 0;
            const expenditure = parseFloat($(this).find('.expenditure').val()) || 0;
            const unused = allocation - expenditure;

            $(this).find('.unused').val(unused);

            totalAllocation += allocation;
            totalExpenditure += expenditure;
            totalUnused += unused;
        });

        $('#total-allocation').text(totalAllocation);
        $('#total-expenditure').text(totalExpenditure);
        $('#total-unused').text(totalUnused);
    }

    function validateRow(row) {
        const allocation = $(row).find('input[name="allocation[]"]').val();
        const expenditure = $(row).find('input[name="expenditure[]"]').val();
        return allocation !== "" && expenditure !== "";
    }

    function addRow() {
        const rowCount = $('#item-table tbody tr').length + 1;
        const newRow = `
            <tr>
                <td>${rowCount}</td>
                <td><input type="text" name="item_name[]" required></td>
                <td><input type="number" name="allocation[]" class="allocation" required></td>
                <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                <td><input type="number" name="unused[]" class="unused" readonly></td>
                <td><span class="remove-row">Remove</span></td>
            </tr>
        `;
        $('#item-table tbody').append(newRow);
        reindexRows();
        updateTotals();
    }

    function reindexRows() {
        $('#item-table tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }

    $('#add-row').on('click', function() {
        addRow();
    });

    $('#item-table').on('input', '.allocation, .expenditure', function() {
        updateTotals();
    });

    $('#item-table').on('click', '.remove-row', function() {
        if (confirm("Are you sure you want to delete this row?")) {
            $(this).closest('tr').remove();
            reindexRows();
            updateTotals();
        }
    });

    $('#item-form').on('submit', function(e) {
        let valid = true;
        $('#item-table tbody tr').each(function() {
            if (!validateRow(this)) {
                valid = false;
                alert('Please fill all fields in all rows before submitting.');
                return false; // exit each loop
            }
        });
        if (!valid) {
            e.preventDefault();
        }
    });

    updateTotals();
});
Step 3: Organize the Directories
CSS File Location:
Place the app.css file in public/css/.

sh
Copy code
public/css/app.css
JavaScript File Location:
Place the app.js file in public/js/.

sh
Copy code
public/js/app.js
Directory Structure
Your Laravel project's directory structure should look something like this:

arduino
Copy code
laravel_project/
├── app/
│   └── ...
├── bootstrap/
│   └── ...
├── config/
│   └── ...
├── database/
│   └── ...
├── public/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── ...
├── resources/
│   ├── views/
│   │   ├── budgets/
│   │   │   └── index.blade.php
│   │   └── layouts/
│   │       └── app.blade.php
│   └── ...
├── routes/
│   └── web.php
├── storage/
│   └── ...
├── tests/
│   └── ...
└── ...
Step 4: Add Routes and Controller Methods
Add necessary routes in routes/web.php:

php
Copy code
use App\Http\Controllers\BudgetController;

Route::resource('budgets', BudgetController::class);
Update your BudgetController to handle the index and store actions:

php
Copy code
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function index()
    {
        return view('budgets.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fiscal_year' => 'required|string',
            'item_name' => 'required|array',
            'allocation' => 'required|array',
            'expenditure' => 'required|array',
            'unused' => 'required|array',
        ]);

        foreach ($data['item_name'] as $index => $item_name) {
            Budget::create([
                'fiscal_year' => $request->fiscal_year,
                'item_name' => $item_name,
                'allocation' => $data['allocation'][$index],
                'expenditure' => $data['expenditure'][$index],
                'unused' => $data['unused'][$index],
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('budgets.index')->with('success', 'Budgets saved successfully');
    }
}
Conclusion
Now you should have a functional index view for budgets with the ability to add, calculate, and store budget items in the database. The CSS and JavaScript files are separated and properly organized in the public directory. This setup ensures a clean and maintainable codebase for your Laravel project.
