<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budget;
use App\Models\Charge;
use App\Constants\Role;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index()
    {
        // $charges = Charge::with('budget', 'user')->get();
        // $charges = Charge::with('user')->get();
        // return view('charges.index', compact('charges'));


        $user = auth()->user();
        $role = $user->role;

        if ($role === Role::ADMIN) {
            $charges = Charge::all();
        } else {
            $charges = Charge::where('user_id', $user->id)->get();
        }

        return view('charges.index', compact('charges'));
    }

    public function create()
    {
        $budgets = Budget::all();
        $users = User::all();
        // $fiscalYears = $budgets->pluck('fiscal_year')->unique();

        // $fiscalYears = $budgets->pluck('fiscal_year')->unique()->sort(function ($a, $b) {
        //     return strtotime(explode('-', $a)[0]) - strtotime(explode('-', $b)[0]);
        // });

        $fiscalYears = Budget::distinct()
            ->orderByRaw("CAST(SUBSTRING_INDEX(fiscal_year, '-', 1) AS UNSIGNED)")
            ->pluck('fiscal_year');

        return view('charges.create', compact('budgets', 'users', 'fiscalYears'));

        // return view('charges.create', compact('budgets', 'users'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'fiscal_year' => 'required|string',
            'bank_charge' => 'required|numeric',
            'check_fee' => 'required|numeric',
            'unspent_refund' => 'required|integer',
            // 'user_id' => 'required|exists:users,id',
            // 'budget_id' => 'required|exists:budgets,id',
            'user_id' => auth()->user()->isAdmin() ? 'required|exists:users,id' : 'nullable',
            'budget_id' => auth()->user()->isAdmin() ? 'required|exists:budgets,id' : 'nullable',
        ]);

        // Charge::create($request->all());
        // $data = $request->all();
        // dd($data);
        if (!auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
            $data['budget_id'] = $request->input('budget_id');
        }

        if (empty($data['budget_id'])) {
            return redirect()->back()->withErrors(['budget_id' => 'The budget field is required.']);
        }

        $chargeExists = Charge::where('fiscal_year', $data['fiscal_year'])
            ->where('user_id', $data['user_id'])
            ->exists();

        if ($chargeExists) {
            return redirect()->back()->withErrors(['fiscal_year' => 'You have already created a charge for this fiscal year.']);
        }

        Charge::create($data);

        return redirect()->route('charges.index')
            ->with('success', 'Charge created successfully.');
    }

    public function show(Charge $charge)
    {
        $charge->load(['budget', 'user']);
        return view('charges.show', compact('charge'));
    }

    public function edit(Charge $charge)
    {
        $budgets = Budget::all();
        $users = User::all();

        $fiscalYears = $budgets->pluck('fiscal_year')->unique()->sort(function ($a, $b) {
            return strtotime(explode('-', $a)[0]) - strtotime(explode('-', $b)[0]);
        });

        return view('charges.edit', compact('charge', 'budgets', 'users', 'fiscalYears'));
    }


    public function update(Request $request, Charge $charge)
    {
        $data = $request->validate([
            'fiscal_year' => 'required|string',
            'bank_charge' => 'required|numeric',
            'check_fee' => 'required|numeric',
            'unspent_refund' => 'required|integer',
            'user_id' => auth()->user()->isAdmin() ? 'required|exists:users,id' : 'nullable',
            'budget_id' => auth()->user()->isAdmin() ? 'required|exists:budgets,id' : 'nullable',
        ]);

        if (!auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
            $data['budget_id'] = $request->input('budget_id');
        }

        if (empty($data['budget_id'])) {
            return redirect()->back()->withErrors(['budget_id' => 'The budget field is required.']);
        }

        $chargeExists = Charge::where('fiscal_year', $data['fiscal_year'])
            ->where('user_id', $data['user_id'])
            ->where('id', '!=', $charge->id)
            ->exists();

        if ($chargeExists) {
            return redirect()->back()->withErrors(['fiscal_year' => 'You have already created a charge for this fiscal year.']);
        }

        $charge->update($data);

        return redirect()->route('charges.index')
            ->with('success', 'Charge updated successfully.');
    }


    public function destroy(Charge $charge)
    {
        $charge->delete();

        return redirect()->route('charges.index')
            ->with('success', 'Charge deleted successfully.');
    }
}
