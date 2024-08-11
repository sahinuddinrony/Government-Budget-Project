{{-- <!DOCTYPE html>
<html> --}}

@extends('layouts.app')

@section('content')

</br>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <a href="{{ route('budgets.create') }}" class="btn btn-primary mb-3">Create New Budget</a>

    @if ($role === \App\Constants\Role::ADMIN)
        <a href="{{ route('budgets.create') }}" class="btn btn-primary mb-3">Create New Budget</a>
        <br>

        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Fiscal Year</th>
                    <th>Item Name</th>
                    <th>Allocation</th>
                    <th>Expenditure</th>
                    <th>Unused</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $budget)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $budget->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('budgets.show', $budget) }}">
                                {{ $budget->fiscal_year }}
                            </a>
                        </td>
                        <td>{{ $budget->item_name }}</td>
                        <td>{{ $budget->allocation }}</td>
                        <td>{{ $budget->expenditure }}</td>
                        <td>{{ $budget->unused }}</td>
                        <td>
                            <a href="{{ route('budgets.show', $budget) }}">View</a>
                            <a href="{{ route('budgets.edit', $budget) }}">Edit</a>
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td>{{ $budgets->sum('allocation') }}</td>
                    <td>{{ $budgets->sum('expenditure') }}</td>
                    <td>{{ $budgets->sum('unused') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @else
        @php
            $fiscalYears = $budgets->sortBy('fiscal_year')->groupBy('fiscal_year');
        @endphp

        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Fiscal Year</th>
                    {{-- <th>Item Name</th> --}}
                    <th>Allocation</th>
                    <th>Expenditure</th>
                    <th>Unused</th>
                    {{-- <th>সর্বশেষ অব্যয়িত টাকা</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fiscalYears as $year => $yearBudgets)
                @php
                    $rowCount = $yearBudgets->count();
                    $totalUnused = $yearBudgets->sum('unused');
                    $totalCharges = $charges->where('fiscal_year', $year)->sum('check_fee')
                                    + $charges->where('fiscal_year', $year)->sum('bank_charge')
                                    + $charges->where('fiscal_year', $year)->sum('unspent_refund');
                    $finalUnusedBudget = $totalUnused - $totalCharges;
                @endphp
                @foreach ($yearBudgets as $index => $budget)
                    <tr>
                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        @if ($loop->first)
                            <td rowspan="{{ $rowCount }}">
                                <a href="{{ route('budgets.show', $budget) }}">
                                    {{ $budget->fiscal_year }}
                                </a>
                            </td>
                        @endif
                        <td>{{ $budget->allocation }}</td>
                        <td>{{ $budget->expenditure }}</td>
                        <td>{{ $budget->unused }}</td>
                        <td>
                            <a href="{{ route('budgets.show', $budget) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><strong>{{ $year }} Fiscal Year Remaining Unused Budget</strong></td>
                    <td colspan="3"><strong>{{ $finalUnusedBudget }}</strong></td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif

@endsection

{{-- </html> --}}
