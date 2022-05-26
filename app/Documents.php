<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

}
