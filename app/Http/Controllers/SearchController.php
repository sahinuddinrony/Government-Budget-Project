<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
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
        return view('search.search_budget');
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
