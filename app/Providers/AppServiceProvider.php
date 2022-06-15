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

    public function boot()
    {
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
            "Puerto Rico" => 'es',
            "Argentina" => 'es',
            "Bolivia" => 'es',
            "Chile" => 'es',
            "Costa Rica" => 'es',
            "Ecuador" => 'es',
            "El Salvador" => 'es',
            "Guatemala" => 'es',
            "Honduras" => 'es',
            "Mexico" => 'es',
            "Nicaragua" => 'es',
            "Panama" => 'es',
            "Paraguay" => 'es',
            "Peru" => 'es',
            "Uruguay" => 'es',
            "Venezuela" => 'es',

            "Belgium" => 'fr',
            "Benin" => 'fr',
            "Burkina Faso" => 'fr',
            "Burundi" => 'fr',
            "Cameroon" => 'fr',
            "Central African Republic" => 'fr',
            "Chad" => 'fr',
            "Comoros" => 'fr',
            "Cote D'Ivoire" => 'fr',
            "Congo, the Democratic Republic of the" => 'fr',
            "Djibouti" => 'fr',
            "Equatorial Guinea" => 'fr',
            "France" => 'fr',
            "Guinea" => 'fr',
            "Haiti" => 'fr',
            'Luxembourg' => 'fr',
            "Madagascar" => 'fr',
            "Mali" => 'fr',
            "Monaco" => 'fr',
            "Niger" => 'fr',
            "Congo" => 'fr',
            "Rwanda" => 'fr',
            "Senegal" => 'fr',
            "Seychelles" => 'fr',
            "Switzerland" => 'fr',
            "Togo" => 'fr',
            "Vanuatu" => 'fr',
            "French Guiana" => 'fr',
            "French Polynesia" => 'fr',
            "French Southern Territories" => 'fr',
            "Martinique" => 'fr',
            "Guyana" => 'fr',
            'Guadeloupe' => 'fr',
            "Reunion" => 'fr',
            "Saint Martin" => 'fr',

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
            'Germany' => 'en',
            'Bosnia and Herzegovina' => 'en',
            'Croatia' => 'en',
            'Serbia' => 'en',
            'Austria' => 'en',
            'Pakistan' => 'en',
            "Afghanistan" => 'en',
            "Aland Islands" => 'en',
            "Albania" => 'en',
            "Algeria" => 'en',
            "American Samoa" => 'en',
            "Andorra" => 'en',
            "Angola" => 'en',
            "Anguilla" => 'en',
            "Antarctica" => 'en',
            "Armenia" => 'en',
            "Aruba" => 'en',
            "Australia" => 'en',
            "Azerbaijan" => 'en',
            "Bahamas" => 'en',
            "Bahrain" => 'en',
            "Bangladesh" => 'en',
            "Belarus" => 'en',
            "Belize" => 'en',
            "Bermuda" => 'en',
            "Bhutan" => 'en',
            "Bonaire, Sint Eustatius and Saba" => 'en',
            "Botswana" => 'en',
            "Bouvet Island" => 'en',
            "Brazil" => 'en',
            "British Indian Ocean Territory" => 'en',
            "Brunei Darussalam" => 'en',
            "Bulgaria" => 'en',
            "Cape Verde" => 'en',
            "China" => 'en',
            "Christmas Island" => 'en',
            "Cocos (Keeling) Islands" => 'en',
            "Cook Islands" => 'en',
            "Curacao" => 'en',
            "Cyprus" => 'en',
            "Czech Republic" => 'en',
            "Denmark" => 'en',
            "Egypt" => 'en',
            "Eritrea" => 'en',
            "Estonia" => 'en',
            "Ethiopia" => 'en',
            "Falkland Islands (Malvinas)" => 'en',
            "Faroe Islands" => 'en',
            "Fiji" => 'en',
            "Finland" => 'en',
            "Gabon" => 'en',
            "Gambia" => 'en',
            "Georgia" => 'en',
            "Ghana" => 'en',
            "Gibraltar" => 'en',
            "Greece" => 'en',
            "Greenland" => 'en',
            "Grenada" => 'en',
            "Guam" => 'en',
            "Guernsey" => 'en',
            "Guinea-Bissau" => 'en',
            "Heard Island and Mcdonald Islands" => 'en',
            "Holy See (Vatican City State)" => 'en',
            "Hong Kong" => 'en',
            "Hungary" => 'en',
            "Iceland" => 'en',
            "India" => 'en',
            "Indonesia" => 'en',
            "Iran, Islamic Republic of" => 'en',
            "Iraq" => 'en',
            "Ireland" => 'en',
            "Isle of Man" => 'en',
            "Israel" => 'en',
            "Italy" => 'en',
            "Japan" => 'en',
            "Jersey" => 'en',
            "Jordan" => 'en',
            "Kazakhstan" => 'en',
            "Kenya" => 'en',
            "Kiribati" => 'en',
            "Korea, Democratic People's Republic of" => 'en',
            "Korea, Republic of" => 'en',
            "Kosovo" => 'en',
            "Kuwait" => 'en',
            "Kyrgyzstan" => 'en',
            "Lao People's Democratic Republic" => 'en',
            "Latvia" => 'en',
            "Lebanon" => 'en',
            "Lesotho" => 'en',
            "Liberia" => 'en',
            "Libyan Arab Jamahiriya" => 'en',
            "Liechtenstein" => 'en',
            "Lithuania" => 'en',
            "Macao" => 'en',
            "Macedonia, the Former Yugoslav Republic of" => 'en',
            "Malawi" => 'en',
            "Malaysia" => 'en',
            "Maldives" => 'en',
            "Malta" => 'en',
            "Marshall Islands" => 'en',
            "Mauritania" => 'en',
            "Mauritius" => 'en',
            "Mayotte" => 'en',
            "Micronesia, Federated States of" => 'en',
            "Moldova, Republic of" => 'en',
            "Mongolia" => 'en',
            "Montenegro" => 'en',
            "Montserrat" => 'en',
            "Morocco" => 'en',
            "Mozambique" => 'en',
            "Myanmar" => 'en',
            "Namibia" => 'en',
            "Nauru" => 'en',
            "Nepal" => 'en',
            "Netherlands Antilles" => 'en',
            "New Caledonia" => 'en',
            "New Zealand" => 'en',
            "Nigeria" => 'en',
            "Niue" => 'en',
            "Norfolk Island" => 'en',
            "Northern Mariana Islands" => 'en',
            "Norway" => 'en',
            "Oman" => 'en',
            "Palau" => 'en',
            "Palestinian Territory, Occupied" => 'en',
            "Papua New Guinea" => 'en',
            "Philippines" => 'en',
            "Pitcairn" => 'en',
            "Poland" => 'en',
            "Portugal" => 'en',
            "Qatar" => 'en',
            "Romania" => 'en',
            "Russian Federation" => 'en',
            "Saint Barthelemy" => 'en',
            "Saint Helena" => 'en',
            "Saint Kitts and Nevis" => 'en',
            "Saint Pierre and Miquelon" => 'en',
            "Saint Vincent and the Grenadines" => 'en',
            "Samoa" => 'en',
            "San Marino" => 'en',
            "Sao Tome and Principe" => 'en',
            "Saudi Arabia" => 'en',
            "Serbia and Montenegro" => 'en',
            "Sierra Leone" => 'en',
            "Singapore" => 'en',
            "Sint Maarten" => 'en',
            "Slovakia" => 'en',
            "Slovenia" => 'en',
            "Solomon Islands" => 'en',
            "Somalia" => 'en',
            "South Africa" => 'en',
            "South Georgia and the South Sandwich Islands" => 'en',
            "South Sudan" => 'en',
            "Sri Lanka" => 'en',
            "Sudan" => 'en',
            "Suriname" => 'en',
            "Swaziland" => 'en',
            "Sweden" => 'en',
            "Syrian Arab Republic" => 'en',
            "Taiwan, Province of China" => 'en',
            "Tajikistan" => 'en',
            "Tanzania, United Republic of" => 'en',
            "Thailand" => 'en',
            "Timor-Leste" => 'en',
            "Tokelau" => 'en',
            "Tonga" => 'en',
            "Tunisia" => 'en',
            "Turkey" => 'en',
            "Turkmenistan" => 'en',
            "Turks and Caicos Islands" => 'en',
            "Tuvalu" => 'en',
            "Uganda" => 'en',
            "Ukraine" => 'en',
            "United Arab Emirates" => 'en',
            "United Kingdom" => 'en',
            "United States Minor Outlying Islands" => 'en',
            "Uzbekistan" => 'en',
            "Viet Nam" => 'en',
            "Virgin Islands, British" => 'en',
            "Virgin Islands, U.s." => 'en',
            "Wallis and Futuna" => 'en',
            "Western Sahara" => 'en',
            "Yemen" => 'en',
            "Zambia" => 'en',
            "Zimbabwe" => 'en',
        ];

        if (!isset($cookie) && !empty($cookie)) {
            App::setLocale($cookie);
        } else {
            if (array_key_exists($country, $languages)) {
                $lang = $languages[$country];
                App::setLocale($lang);
            } else {
                App::setLocale(App::getLocale());
            }
        }

        setlocale(LC_TIME, "fr_FR");
        Schema::defaultStringLength(191);

        View::composer('admin.layouts.components.sidebar', 'App\Http\Composers\BackendMenuComposer');
        View::composer('partials._footer', 'App\Http\Composers\FrontendFooterComposer');
    }

}
