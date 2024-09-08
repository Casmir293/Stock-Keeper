<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product', 'quantity', 'cost_price', 'selling_price', 'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
