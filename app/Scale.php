<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }
}
