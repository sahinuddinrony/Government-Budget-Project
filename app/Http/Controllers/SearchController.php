<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function summary(Budget $budget)
    {
        $userId = auth()->id();

        // Retrieve budgets for the authenticated user and the selected fiscal year
        // $budgets = Budget::with('charges')

        $budgets = Budget::with('items')
            ->where('user_id', $userId)
            // ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        if ($budgets->isEmpty()) {
            return redirect()->route('budgets.index')->with('error', 'No budgets found for the selected fiscal year.');
        }

        // Retrieve charges related to the budgets for the selected fiscal year
        $charges = Charge::where('user_id', $userId)
            // ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        $fiscal_year = $budget->fiscal_year;

        return view('search.total_budget_summary', compact('budgets', 'charges', 'fiscal_year', 'budget'));
    }
}
