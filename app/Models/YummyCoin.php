<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YummyCoin extends Model
{
  protected $table       = 'yummycoins';
  protected $auditColumn = true;
  protected $fillable    = ['nombre', 'valeur', 'actif'];
}
