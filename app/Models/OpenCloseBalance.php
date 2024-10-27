<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenCloseBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'open_balance',
        'close_balance',
        'remarks',
        'user_id',
        'exchange_id',
    ];
}
