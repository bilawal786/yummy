<?php

namespace App\Providers;
use App;
use Cookie;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot(){
        //Check for 'lang' cookie
        $cookie = Cookie::get('lang');
        //Get visitors IP
        $ip = \Request::ip();

        //Get visitors Geo info based on his IP
        $geo = GeoIP::getLocation($ip);

        //Get visitors country name
        $country = $geo['country'];

        $languages = [

            'Spain' => 'es',
            'Cuba' => 'es',
            'Dominican Republic' => 'es',
            'Colombia' => 'es',
            'United States' => 'en',
            'U.S. Virgin Islands' => 'en',
            'British Virgin Islands' => 'en',
            'Netherlands' => 'en',
            'Cambodia' => 'en',
            'Barbados' => 'en',
            'Dominicas' => 'en',
            'Trinidad and Tobago' => 'en',
            'Antigua and Barbuda' => 'en',
            'Dominica' => 'en',
            'St Kitts and Nevis' => 'en',
            'St Vincent and Grenadines' => 'en',
            'Saint Lucia' => 'en',
            'Jamaica' => 'en',
            'Cayman Islands' => 'en',
            'Canada' => 'en',
            'Germany' => 'de',
            'Bosnia and Herzegovina' => 'ba',
            'Croatia' => 'ba',
            'Serbia' => 'ba',
            'Austria' => 'de',
            'Luxembourg' => 'de',
            'Guadeloupe' => 'gp',
            'Pakistan' => 'en',
        ];

        if(!isset($cookie) && !empty($cookie)) {
            App::setLocale($cookie);
        }else {
            if (array_key_exists($country, $languages)) {
                $lang = $languages[$country];
                 App::setLocale($lang);
            }
            else {
                App::setLocale(App::getLocale());
            }
        }

        setlocale(LC_TIME, "fr_FR");
        Schema::defaultStringLength(191);

        View::composer('admin.layouts.components.sidebar', 'App\Http\Composers\BackendMenuComposer');
        View::composer('partials._footer', 'App\Http\Composers\FrontendFooterComposer');
    }

}
