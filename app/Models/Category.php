<?php

namespace App\Models;

use App\Models\BaseModel;
use Carbon\Carbon;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends BaseModel implements HasMedia
{
    use HasSlug, WatchableTrait, HasMediaTrait;

    protected $table       = 'categories';
    protected $auditColumn = true;
    protected $fillable    = ['name', 'slug', 'description', 'status'];
    protected $with        = ['shops','products'];

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'category_shops', 'category_id', 'shop_id')->latest();
    }
    public function country()
    {
        return $this->belongsTo(Location::class, 'country_id');
    }

    public function products()
    {
//        $json = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . request()->ip());
//        $details = json_decode($json);
//        dd($details->geoplugin_timezone);
//        ->timezone($details->geoplugin_timezone)
        return $this->belongsToMany(Product::class, 'category_products', 'category_id', 'product_id')->where('publish', '<', Carbon::today())->orwhere('publish', null)->latest();
    }
    public function qty()
    {
        return $this->products()->sum('quantity');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('categories'))) {
            return asset($this->getFirstMediaUrl('categories'));
        }
        return asset('assets/img/default/category.png');
    }
}
