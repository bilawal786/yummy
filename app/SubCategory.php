<?php

namespace App;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
