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
        // $budgets = Budget::with('user')->get();
        {
            $user = Auth::user();
            $role = $user->role;

            if ($role === Role::ADMIN) {
                // $budgets = Budget::all();
                $budgets = Budget::with('items')->get();
            } else {
                // $budgets = Budget::where('user_id', $user->id)->get();
                $budgets = Budget::where('user_id', $user->id)->with('items')->get();
                $charges = Charge::where('user_id', $user->id)->get();
                // dd($budgets);
            }

            return view('budgets.index', compact('budgets', 'role', 'charges'));
        }
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(BudgetRequest $request)
    {
        // dd($request);
        $data = $request->validated();

        $data['uuid'] = Str::uuid();

        // Check for existing budget
        if (Budget::where('user_id', auth()->id())
            ->where('fiscal_year', $data['fiscal_year'])
            ->exists()
        ) {
            return redirect()->back()->with('success', 'Budget already exists.');
        }

        // Create the budget
        $budget = Budget::create([
            // 'uuid' => Str::uuid(),
            'uuid' => $data['uuid'],
            'fiscal_year' => $data['fiscal_year'],
            'allocation' => array_sum($data['allocation']),
            'expenditure' => array_sum($data['expenditure']),
            'unused' => array_sum($data['allocation']) - array_sum($data['expenditure']),
            'user_id' => auth()->id(),
        ]);

        foreach ($data['item_name'] as $index => $itemName) {
            Item::create([
                'uuid' => Str::uuid(),
                'budget_id' => $budget->id,
                'item_code' => $data['item_code'][$index] ?? null,
                'item_name' => $itemName,
                'item_allocation' => $data['allocation'][$index],
                'item_expenditure' => $data['expenditure'][$index],
                'item_unused' => $data['allocation'][$index] - $data['expenditure'][$index],
            ]);
        }

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }



    public function show(Budget $budget)
    {
        $userId = auth()->id();

        // Retrieve budgets for the authenticated user and the selected fiscal year
        // $budgets = Budget::with('charges')

        $budgets = Budget::with('items')
            ->where('user_id', $userId)
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
        $userId = auth()->id();

        // Retrieve the budget items and charges
        // $budget->load('items');

        // Eager load budget items and charges in a single query
        $budget = Budget::with('items')
            ->where('id', $budget->id)
            ->first();

        $charges = Charge::where('user_id', $userId)
            ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        return view('budgets.edit', compact('budget', 'charges'));
    }

    public function update(Request $request, Budget $budget)
    {
        $data = $request->validate([
            'fiscal_year' => 'required',
            'items.*.item_code' => 'required',
            'items.*.item_name' => 'required',
            'items.*.item_allocation' => 'required|numeric',
            'items.*.item_expenditure' => 'required|numeric',
            'items.*.item_unused' => 'required|numeric',
        ]);


        // $budget->update($request->only(['fiscal_year', 'item_allocation']));

        $totalAllocation = 0;
        $totalExpenditure = 0;

        foreach ($data['items'] as $itemData) {
            $totalAllocation += $itemData['item_allocation'];
            $totalExpenditure += $itemData['item_expenditure'];
        }

        $budget->update([
            'fiscal_year' => $data['fiscal_year'],
            'allocation' => $totalAllocation,
            'expenditure' => $totalExpenditure,
            'unused' => $totalAllocation - $totalExpenditure,
        ]);

        foreach ($request->items as $itemData) {
            $item = $budget->items()->find($itemData['id']);
            if ($item) {
                $item->update($itemData);
            }
        }

        return redirect()->route('budgets.show', $budget->id)->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Data deleted successfully');
    }
}
