{{-- <!DOCTYPE html>
<html> --}}

@extends('layouts.app')

@section('content')

    <h1>Budgets</h1>
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
                    @php $rowCount = $yearBudgets->count(); @endphp
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
                            {{-- <td style="text-align: left;">
                                @foreach ($budget->items as $item)
                                    {{ $item->item_name }}<br>
                                @endforeach
                            </td> --}}
                            {{-- <td>{{ $budget->item_name }}</td> --}}
                            <td>{{ $budget->allocation }}</td>
                            <td>{{ $budget->expenditure }}</td>
                            <td>{{ $budget->unused }}</td>
                            {{-- <td>{{ $budget->item_name }}</td> --}}
                            {{-- <td>
                                <strong>
                                    {{ \App\Helpers\NumberHelper::toBangla($budgets->sum('unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund'))) }}
                                </strong>
                            </td> --}}
                            {{-- <td><strong>{{ \App\Helpers\NumberHelper::toBangla($totalUnusedBudget) }}</strong></td> --}}
                            <td>
                                <a href="{{ route('budgets.show', $budget) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>{{ $year }} অর্থবছরের সর্বশেষ অব্যয়িত টাকা</strong></td>
                        {{-- <td colspan="3"><strong>{{ \App\Helpers\NumberHelper::toBangla($totalUnusedBudget) }}</strong></td> --}}
                        {{-- <td>{{ $yearBudgets->sum('allocation') }}</td>
                        <td>{{ $yearBudgets->sum('expenditure') }}</td>
                        <td>{{ $yearBudgets->sum('unused') }}</td> --}}

                        {{-- <td> {{ \App\Helpers\NumberHelper::toBangla($budgets->sum('unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund'))) }} </td> --}}

                        <td colspan="3"><strong>{{ $budget->unused }}</strong></td>
                        {{-- <td colspan="3"><strong>{{ $yearBudgets->sum('unused') - ($charges->sum('check_fee') + $charges->sum('bank_charge') + $charges->sum('unspent_refund')) }}</strong></td> --}}
                        {{-- <td colspan="3"><strong>{{ $yearBudgets->sum('unused') - ($charges->check_fee + $charges->bank_charge + $charges->unspent_refund) }}</strong></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection

{{-- </html> --}}
