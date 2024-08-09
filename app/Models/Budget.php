<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use App\Models\Charge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'fiscal_year',
        'allocation',
        'expenditure',
        'unused',
        'user_id',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'uuid';
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }


    // public function charges()
    // {
    //     return $this->hasMany(Charge::class,'user_id');
    // }

    // public function charges()
    // {
    //     return $this->belongsTo(Charge::class);
    // }


}
