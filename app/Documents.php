<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Carbon\Carbon;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Documents extends BaseModel implements HasMedia
{
    protected $table       = 'documents';
    protected $fillable    = ['user_id', 'file'];
    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('categories'))) {
            return asset($this->getFirstMediaUrl('categories'));
        }
        return asset('assets/img/default/category.png');
    }
}
