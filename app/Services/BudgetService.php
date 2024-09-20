<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Budget;
use Illuminate\Support\Str;

class BudgetService
{
    /**
     * Create a new class instance.
     */
    public function store($data)
    {
        $data['uuid'] = Str::uuid();

        if (Budget::where('user_id', auth()->id())
            ->where('fiscal_year', $data['fiscal_year'])
            ->exists()
        ) {
            return redirect()->back()->with('success', 'Budget already exists.');
        }

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
    }

    public function update($data, Budget $budget)
    {
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

        
    }
}
