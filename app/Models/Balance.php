<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends BaseModel
{
    protected $table  = 'balances';
    protected $fillable    = ['name', 'balance'];
}
