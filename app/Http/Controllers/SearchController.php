<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Budget;
use App\Models\Charge;
use App\Constants\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $role = $user->role;

        // Initialize variables
        $charges = collect();
        $totalAllocation = $totalExpenditure = $totalUnused = $totalUnspentRefund = $totalUsers = 0;

        if ($role === Role::ADMIN) {
            $budgets = Budget::with('items')->get();

            // Calculate totals for admin
            $totalAllocation = Item::sum('item_allocation');
            $totalExpenditure = Item::sum('item_expenditure');
            $totalUnused = Item::sum('item_unused');
            $totalUnspentRefund = Charge::sum('unspent_refund');
            $totalUsers = User::count();  // Assuming you have a User model
        } else {
            $budgets = Budget::where('user_id', $user->id)->with('items')->get();
            $charges = Charge::where('user_id', $user->id)->get();

            $unspentRefund = $charges->sum('unspent_refund');
            $fiscalYearCount = $charges->groupBy('fiscal_year')->count();
        }

        return view('dashboard', compact(
            'budgets',
            'role',
            'charges',
            'totalAllocation',
            'totalExpenditure',
            'totalUnused',
            'totalUnspentRefund',
            'totalUsers',
            'unspentRefund',
            'fiscalYearCount'
        ));
    }

    public function summary()
    {
        $userId = auth()->id();

        // Retrieve all budgets for the authenticated user
        $budgets = Budget::with('items')
            ->where('user_id', $userId)
            ->get();

        if ($budgets->isEmpty()) {
            return redirect()->route('budgets.index')->with('error', 'No budgets found.');
        }

        // Retrieve all charges related to the authenticated user
        $charges = Charge::where('user_id', $userId)->get();

        // Calculate totals across all fiscal years
        $totalAllocation = $budgets->sum(fn($budget) => $budget->items->sum('item_allocation'));
        $totalExpenditure = $budgets->sum(fn($budget) => $budget->items->sum('item_expenditure'));
        $totalUnused = $budgets->sum(fn($budget) => $budget->items->sum('item_unused'));

        // Calculate totals for charges
        $checkFeeTotal = $charges->sum('check_fee');
        $bankChargeTotal = $charges->sum('bank_charge');
        $unspentRefundTotal = $charges->sum('unspent_refund');

        // Final unused funds after deducting charges
        $finalUnused = $totalUnused - ($checkFeeTotal + $bankChargeTotal + $unspentRefundTotal);

        return view('search.total_budget_summary', compact(
            'budgets',
            'charges',
            'totalAllocation',
            'totalExpenditure',
            'totalUnused',
            'checkFeeTotal',
            'bankChargeTotal',
            'unspentRefundTotal',
            'finalUnused'
        ));
    }

    public function showSearchForm()
    {
        $fiscalYears = Budget::distinct()
            ->orderByRaw("CAST(SUBSTRING_INDEX(fiscal_year, '-', 1) AS UNSIGNED)")
            ->pluck('fiscal_year');

        return view('search.search_budget', compact('fiscalYears'));
    }

    public function searchBetweenFiscalYears(Request $request)
    {
        $request->validate([
            'start_fiscal_year' => 'required|string',
            'end_fiscal_year' => 'required|string',
        ]);

        $userId = auth()->id();
        $startFiscalYear = $request->input('start_fiscal_year');
        $endFiscalYear = $request->input('end_fiscal_year');

        // Retrieve budgets between the specified fiscal years for the authenticated user
        $budgets = Budget::with('items')
            ->where('user_id', $userId)
            ->whereBetween('fiscal_year', [$startFiscalYear, $endFiscalYear])
            ->get();

        if ($budgets->isEmpty()) {
            return redirect()->route('budgets.search')->with('error', 'No budgets found between the selected fiscal years.');
        }

        // Retrieve charges related to the budgets for the selected fiscal years
        $charges = Charge::where('user_id', $userId)
            ->whereBetween('fiscal_year', [$startFiscalYear, $endFiscalYear])
            ->get();

        return view('search.search_budget', compact('budgets', 'charges', 'startFiscalYear', 'endFiscalYear'));
    }
}
