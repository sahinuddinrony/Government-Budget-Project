<?php

namespace App\Models;

use App\Models\User;
use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'fiscal_year',
        'bank_charge',
        'check_fee',
        'unspent_refund',
        'unspent_money',
        'user_id',

    ];

    // public function budget()
    // {
    //     return $this->belongsTo(Budget::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function budgets()
    // {
    //     return $this->hasMany(Budget::class);
    // }
}
