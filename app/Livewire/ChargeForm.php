<?php

namespace App\Livewire;

use Livewire\Component;

// namespace App\Http\Livewire;

// use Livewire\Component;
use App\Models\Budget;

class ChargeForm extends Component
{
    public $fiscalYears;
    public $fiscalYear;
    public $unspentMoney;
    public $checkFee = 0;
    public $bankCharge = 0;
    public $totalBankExpenditure = 0;
    public $totalBalance = 0;

    protected $listeners = ['calculateTotalExpenditure'];

    public function mount($fiscalYears)
    {
        $this->fiscalYears = $fiscalYears;
    }

    public function updatedFiscalYear($value)
    {
        $budget = Budget::where('fiscal_year', $value)
            ->where('user_id', auth()->id())
            ->first();

        $this->unspentMoney = $budget->unused ?? 0;

        $this->calculateTotalExpenditure();
    }

    public function updatedCheckFee()
    {
        $this->calculateTotalExpenditure();
    }

    public function updatedBankCharge()
    {
        $this->calculateTotalExpenditure();
    }

    public function calculateTotalExpenditure()
    {
        $this->totalBankExpenditure = $this->checkFee + $this->bankCharge;
        $this->totalBalance = $this->unspentMoney - $this->totalBankExpenditure;
    }

    public function render()
    {
        return view('livewire.charge-form');
    }
}

