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
