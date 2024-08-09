<?php

namespace App\Models;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'item_code',
        'item_name',
        'item_allocation',
        'item_expenditure',
        'item_unused',
        'budget_id',
    ];

    public function budgets()
    {
        return $this->belongsTo(Budget::class);
    }
}
