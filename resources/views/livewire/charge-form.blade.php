<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label><strong>Fiscal Year</strong></label>
            <select wire:model="fiscalYear" class="form-control">
                @foreach ($fiscalYears as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label><strong>Unspent Money</strong></label>
            <input type="number" wire:model="unspentMoney" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label><strong>Check Fee</strong></label>
            <input type="number" wire:model="checkFee" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Bank Charge</strong></label>
            <input type="number" wire:model="bankCharge" class="form-control">
        </div>

        <div class="form-group">
            <label><strong>Total Bank Expenditure</strong></label>
            <input type="number" wire:model="totalBankExpenditure" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label><strong>Total Balance</strong></label>
            <input type="number" wire:model="totalBalance" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
