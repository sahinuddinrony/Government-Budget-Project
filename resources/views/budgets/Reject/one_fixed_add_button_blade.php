<!DOCTYPE html>
<html>

<head>
    <title>Information Input Table</title>
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

        .text-right {
            text-align: right;
        }

        .remove-row {
            cursor: pointer;
            color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Information Input Table</h2>

        <form id="item-form" action="{{ route('budgets.store') }}" method="POST">
            @csrf
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
                        <td><input type="text" name="item_name[]" required></td>
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

            $('#item-table tbody tr').each(function () {
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
            const itemName = $(row).find('input[name="item_name[]"]').val();
            const allocation = $(row).find('input[name="allocation[]"]').val();
            const expenditure = $(row).find('input[name="expenditure[]"]').val();
            return itemName !== "" && allocation !== "" && expenditure !== "";
        }

        $(document).ready(function () {
            $('#add-row').on('click', function () {
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
                updateTotals();
            });

            $('#item-table').on('input', '.allocation, .expenditure', function () {
                updateTotals();
            });

            $('#item-table').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateTotals();
            });

            $('#item-form').on('submit', function (e) {
                e.preventDefault();
                let valid = true;
                $('#item-table tbody tr').each(function () {
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
</body>

</html>
