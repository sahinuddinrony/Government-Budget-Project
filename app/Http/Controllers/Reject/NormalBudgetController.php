<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Constants\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                // Admin can see all fruits
                $budgets = Budget::all();
            } else {
                // Other users can only see their own fruits
                $budgets = Budget::where('user_id', $user->id)->get();
            }

            // dd($fruits);

            return view('budgets.index', compact('budgets', 'role'));
        }

    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'fiscal_year' => 'required|string',
        'item_name' => 'required|array',
        'item_name.*' => 'required|string',
        'allocation' => 'required|array',
        'allocation.*' => 'required|numeric',
        'expenditure' => 'required|array',
        'expenditure.*' => 'required|numeric',
    ]);

    $userId = auth()->id();
    if (!$userId) {
        return redirect()->route('budgets.create')->with('error', 'User must be logged in to create a Budget.');
    }

    // $data['user_id'] = $userId;

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

    return redirect()->route('budgets.index')->with('success', 'Data submitted successfully');
}


    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
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
