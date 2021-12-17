<?php

namespace App;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
