@extends('layouts.app')

@section('content')

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
                    <th>ক্রমিক</th>
                    <th>অর্থনৈতিক কোড</th>
                    <th>ব্যয়ের খাত</th>
                    <th>মোট বরাদ্ধ</th>
                    <th>মোট ব্যয়</th>
                    <th>অব্যয়িত</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    {{-- <td><input type="text" name="item_code[]" required></td> --}}
                    <td>
                        <input type="hidden" name="item_code[]" value="৩১১১১০১">৩১১১১০১
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="অফিসারদের বেতন"> অফিসারদের বেতন
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                 <tr>
                    <td>2</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩১১১৩২৫">৩১১১৩২৫
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="উৎসব ভাতা">উৎসব ভাতা
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="item_unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
               <tr>
                    <td>3</td>
                    <td>
                        <input type="hidden" name="item_code[]" value="৩১১১৩২৫">৩১১১৩২৫
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="নববর্ষ ভাতা">নববর্ষ ভাতা
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        <input type="hidden" name="item_code[]" value="৩২১১১২৯">৩২১১১২৯
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="অফিস ভাড়া">অফিস ভাড়া
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>5</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২১১১১৩">৩২১১১১৩
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="বিদ্যুৎ">বিদ্যুৎ
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>6</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২১১১২০">৩২১১১২০
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="টেলিফোন ও ইন্টারনেট">টেলিফোন ও ইন্টারনেট
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>7</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২১১১১৯">৩২১১১১৯
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="ডাক">ডাক
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>8</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৫৫১০৪">৩২৫৫১০৪
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="স্টেশনারী">স্টেশনারী
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>9</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৪১১০১">৩২৪১১০১
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="টি এ/ ডি এ"> টি এ/ ডি এ
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>10</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২১১১২৫">৩২১১১২৫
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="প্রচার ও বিজ্ঞাপণ">প্রচার ও বিজ্ঞাপণ
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>11</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩১১১৩৩২">৩১১১৩৩২
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="সম্মানীভাতা/ফি/পারিশ্রমিক">সম্মানীভাতা/ফি/পারিশ্রমিক
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>12</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৫৬১০৫">৩২৫৬১০৫
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="কাঁচামাল ও খুচরা যন্ত্রাংশ">কাঁচামাল ও খুচরা যন্ত্রাংশ
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>13</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৫৮১০৩">৩২৫৮১০৩
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="কম্পিউটার ও অফিস সরঞ্জাম মেরামত">কম্পিউটার ও অফিস সরঞ্জাম মেরামত
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>14</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৫৮১০২">৩২৫৮১০২
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="আসবাবপত্র মেরামত">আসবাবপত্র মেরামত
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
                <tr>
                    <td>15</td>

                    <td>
                        <input type="hidden" name="item_code[]" value="৩২৫৬১০৩">৩২৫৬১০৩
                    </td>
                    <td>
                        <input type="hidden" name="item_name[]" value="বিবিধ (ব্যবহার্য দ্রব্যাদি)">বিবিধ (ব্যবহার্য দ্রব্যাদি)
                    </td>
                    <td><input type="number" name="allocation[]" class="allocation" required></td>
                    <td><input type="number" name="expenditure[]" class="expenditure" required></td>
                    <td><input type="number" name="unused[]" class="unused" readonly></td>
                    <td><span class="remove-row">Remove</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">সর্বমোট =</td>
                    <td id="total-allocation">0</td>
                    <td id="total-expenditure">0</td>
                    <td id="total-unused">0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <button type="button" id="add-row" class="btn btn-primary">Add Row</button>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-primary">Clear</button>
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
        const itemCode = $(row).find('input[name="item_code[]"]').val();
        const allocation = $(row).find('input[name="allocation[]"]').val();
        const expenditure = $(row).find('input[name="expenditure[]"]').val();
        return itemCode !== "" && allocation !== "" && expenditure !== "";
    }

    function addRow() {
        const rowCount = $('#item-table tbody tr').length + 1;
        const newRow = `
            <tr>
                <td>${rowCount}</td>
                <td><input type="text" name="item_code[]" required></td>
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

@endsection
