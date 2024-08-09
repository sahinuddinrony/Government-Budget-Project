{{-- <!DOCTYPE html>
<html> --}}
    @extends('layouts.app')

    @section('content')

{{-- <head>
    <title>Information Input Table</title>
    @include('layouts.style')
    <style>
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

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
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

        .error {
            color: red;
            font-size: 0.875em;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .remove-row {
            cursor: pointer;
            color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head> --}}

{{-- <body> --}}

    @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

    <div class="container">
        <h2>Information Input Table</h2>

        <form id="item-form" action="{{ route('budgets.store') }}" method="POST">
            @csrf
            <div>
                <select id="fiscal-year-select" name="fiscal_year" required>
                    <option value="">--Select Fiscal Year--</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                </select>

                @error('fiscal_year')
                    <p class="text-red-700 p-2">{{ $message }}</p>
                @enderror
            </div>

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
                        <td>
                            <input type="hidden" name="item_name[]" value="Computer">Computer
                        </td>
                        <td><input type="number" name="allocation[]" class="allocation" required></td>
                        <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                        <td><input type="number" name="unused[]" class="unused" readonly></td>
                        <td><span class="remove-row">Remove</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <input type="hidden" name="item_name[]" value="Salary">Salary
                        </td>
                        <td><input type="number" name="allocation[]" class="allocation" required></td>
                        <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                        <td><input type="number" name="unused[]" class="unused" readonly></td>
                        <td><span class="remove-row">Remove</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <input type="hidden" name="item_name[]" value="House Rent">House Rent
                        </td>
                        <td><input type="number" name="allocation[]" class="allocation" required></td>
                        <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                        <td><input type="number" name="unused[]" class="unused" readonly></td>
                        <td><span class="remove-row">Remove</span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <input type="hidden" name="item_name[]" value="Current Bill">Current Bill
                        </td>
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

    <script>
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
                    <td>
                        <input type="text" name="item_name[]" required>
                    </td>
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

        $(document).ready(function() {
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
                e.preventDefault();
                let valid = true;
                $('#item-table tbody tr').each(function() {
                    if (!validateRow(this)) {
                        valid = false;
                        alert('Please fill all fields in all rows before submitting.');
                        return false; // exit each loop
                    }
                });
                if (valid) {
                    this.submit();
                }
            });

            updateTotals();
        });
    </script>
{{-- </body> --}}
@endsection

{{-- </html> --}}
