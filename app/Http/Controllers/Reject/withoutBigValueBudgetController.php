<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Budget;
use App\Models\Charge;
// use Barryvdh\DomPDF\PDF;
use App\Constants\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        // $budgets = Budget::all();
        // $budgets = Budget::with('user')->get();
        {
            $user = Auth::user();
            $role = $user->role;

            if ($role === Role::ADMIN) {
                $budgets = Budget::all();
            } else {
                $budgets = Budget::where('user_id', $user->id)->get();
            }

            return view('budgets.index', compact('budgets', 'role'));
        }
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(BudgetRequest $request)
    {
        $data = $request->validated();
        $validated['uuid'] = Str::uuid();
        dd($data);

        $userId = auth()->id();

        // $data['user_id'] = $userId;

        $budgetExists = Budget::where('user_id', $userId)
            ->where('fiscal_year', $data['fiscal_year'])
            ->exists();

        if ($budgetExists) {
            return redirect()->back()->with('success', 'You have already created a budget for this fiscal year.');
        }

        foreach ($data['item_name'] as $index => $itemName) {
            Budget::create([
                'fiscal_year' => $data['fiscal_year'],
                'item_name' => $itemName,
                'allocation' => $data['allocation'][$index],
                'expenditure' => $data['expenditure'][$index],
                'unused' => $data['allocation'][$index] - $data['expenditure'][$index],
                'user_id' => $userId,
            ]);
        }

        $item = Item::create([
            'budget_id' => $budget->id,
            'item_code' => $validated['item_code'],
            'item_name' => $validated['item_name'],
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }



    public function show(Budget $budget)
    {
        $userId = auth()->id();

        // Retrieve budgets for the authenticated user and the selected fiscal year
        // $budgets = Budget::with('charges')
        $budgets = Budget::where('user_id', $userId)
            ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        if ($budgets->isEmpty()) {
            return redirect()->route('budgets.index')->with('error', 'No budgets found for the selected fiscal year.');
        }

        // Retrieve charges related to the budgets for the selected fiscal year
        $charges = Charge::where('user_id', $userId)
            ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        $fiscal_year = $budget->fiscal_year;

        return view('budgets.show', compact('budgets', 'charges', 'fiscal_year', 'budget'));
    }



    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {

        // $budget->update($request->all());
        $data = $request->validate([
            'item_name' => 'required|string',
            'allocation' => 'required|numeric',
            'expenditure' => 'required|numeric',
        ]);

        $data['unused'] = $data['allocation'] - $data['expenditure'];

        $budget->update($data);

        return redirect()->route('budgets.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Data deleted successfully');
    }
}
