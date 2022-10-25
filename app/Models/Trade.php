<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
      'usdt',
        'user_id',
        'amount'
    ];

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
