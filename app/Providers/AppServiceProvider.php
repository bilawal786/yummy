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


             "Afghanistan"=> 'en',
             "Aland Islands"=> 'en',
             "Albania"=> 'en',
             "Algeria"=> 'en',
             "American Samoa"=> 'en',
             "Andorra"=> 'en',
             "Angola"=> 'en',
             "Anguilla"=> 'en',
             "Antarctica"=> 'en',
            "Argentina"=> 'en',
             "Armenia"=> 'en',
             "Aruba"=> 'en',
            "Australia"=> 'en',
             "Azerbaijan"=> 'en',
             "Bahamas"=> 'en',
             "Bahrain"=> 'en',
             "Bangladesh"=> 'en',
            "Belarus"=> 'en',
             "Belgium"=> 'en',
            "Belize"=> 'en',
            "Benin"=> 'en',
             "Bermuda"=> 'en',
             "Bhutan"=> 'en',
             "Bolivia"=> 'en',
            "Bonaire, Sint Eustatius and Saba"=> 'en',
            "Botswana"=> 'en',
             "Bouvet Island"=> 'en',
             "Brazil"=> 'en',
             "British Indian Ocean Territory"=> 'en',
            "Brunei Darussalam"=> 'en',
             "Bulgaria"=> 'en',
             "Burkina Faso"=> 'en',
             "Burundi"=> 'en',
            "Cameroon"=> 'en',
            "Cape Verde"=> 'en',
            "Central African Republic"=> 'en',
             "Chad"=> 'en',
            "Chile"=> 'en',
             "China"=> 'en',
             "Christmas Island"=> 'en',
            "Cocos (Keeling) Islands"=> 'en',
             "Comoros"=> 'en',
            "Congo"=> 'en',
             "Congo, the Democratic Republic of the"=> 'en',
            "Cook Islands"=> 'en',
             "Costa Rica"=> 'en',
            "Cote D'Ivoire"=> 'en',
             "Curacao"=> 'en',
             "Cyprus"=> 'en',
            "Czech Republic"=> 'en',
             "Denmark"=> 'en',
             "Djibouti"=> 'en',
            "Ecuador"=> 'en',
            "Egypt"=> 'en',
             "El Salvador"=> 'en',
            "Equatorial Guinea"=> 'en',
             "Eritrea"=> 'en',
             "Estonia"=> 'en',
             "Ethiopia"=> 'en',
             "Falkland Islands (Malvinas)"=> 'en',
             "Faroe Islands"=> 'en',
             "Fiji"=> 'en',
             "Finland"=> 'en',
             "France"=> 'en',
            "French Guiana"=> 'en',
             "French Polynesia"=> 'en',
             "French Southern Territories"=> 'en',
            "Gabon"=> 'en',
            "Gambia"=> 'en',
             "Georgia"=> 'en',
            "Ghana"=> 'en',
             "Gibraltar"=> 'en',
             "Greece"=> 'en',
             "Greenland"=> 'en',
            "Grenada"=> 'en',
            "Guam"=> 'en',
             "Guatemala"=> 'en',
            "Guernsey"=> 'en',
             "Guinea"=> 'en',
             "Guinea-Bissau"=> 'en',
             "Guyana"=> 'en',
             "Haiti"=> 'en',
             "Heard Island and Mcdonald Islands"=> 'en',
             "Holy See (Vatican City State)"=> 'en',
             "Honduras"=> 'en',
             "Hong Kong"=> 'en',
             "Hungary"=> 'en',
            "Iceland"=> 'en',
             "India"=> 'en',
             "Indonesia"=> 'en',
            "Iran, Islamic Republic of"=> 'en',
             "Iraq"=> 'en',
             "Ireland"=> 'en',
             "Isle of Man"=> 'en',
             "Israel"=> 'en',
             "Italy"=> 'en',
             "Japan"=> 'en',
             "Jersey"=> 'en',
             "Jordan"=> 'en',
             "Kazakhstan"=> 'en',
            "Kenya"=> 'en',
            "Kiribati"=> 'en',
            "Korea, Democratic People's Republic of"=> 'en',
             "Korea, Republic of"=> 'en',
             "Kosovo"=> 'en',
             "Kuwait"=> 'en',
             "Kyrgyzstan"=> 'en',
            "Lao People's Democratic Republic",
             "Latvia" => 'en',
            "Lebanon" => 'en',
            "Lesotho" => 'en',
             "Liberia"=> 'en',
             "Libyan Arab Jamahiriya"=> 'en',
             "Liechtenstein"=> 'en',
             "Lithuania"=> 'en',
             "Macao"=> 'en',
            "Macedonia, the Former Yugoslav Republic of" => 'en',
             "Madagascar" => 'en',
             "Malawi" => 'en',
            "Malaysia"=> 'en',
             "Maldives" => 'en',
            "Mali"=> 'en',
            "Malta" => 'en',
            "Marshall Islands"=> 'en',
            "Martinique"=> 'en',
             "Mauritania"=> 'en',
            "Mauritius"=> 'en',
            "Mayotte"=> 'en',
             "Mexico"=> 'en',
            "Micronesia, Federated States of"=> 'en',
             "Moldova, Republic of"=> 'en',
            "Monaco"=> 'en',
             "Mongolia"=> 'en',
             "Montenegro"=> 'en',
             "Montserrat"=> 'en',
             "Morocco"=> 'en',
            "Mozambique"=> 'en',
            "Myanmar"=> 'en',
            "Namibia"=> 'en',
            "Nauru"=> 'en',
            "Nepal"=> 'en',
             "Netherlands Antilles"=> 'en',
            "New Caledonia"=> 'en',
            "New Zealand"=> 'en',
            "Nicaragua"=> 'en',
            "Niger"=> 'en',
            "Nigeria"=> 'en',
             "Niue"=> 'en',
             "Norfolk Island"=> 'en',
            "Northern Mariana Islands"=> 'en',
            "Norway"=> 'en',
            "Oman"=> 'en',
             "Palau"=> 'en',
            "Palestinian Territory, Occupied"=> 'en',
             "Panama"=> 'en',
            "Papua New Guinea"=> 'en',
            "Paraguay"=> 'en',
            "Peru"=> 'en',
            "Philippines"=> 'en',
            "Pitcairn"=> 'en',
            "Poland"=> 'en',
             "Portugal"=> 'en',
            "Puerto Rico"=> 'en',
             "Qatar"=> 'en',
           "Reunion"=> 'en',
             "Romania"=> 'en',
             "Russian Federation"=> 'en',
            "Rwanda"=> 'en',
             "Saint Barthelemy"=> 'en',
            "Saint Helena"=> 'en',
            "Saint Kitts and Nevis"=> 'en',
            "Saint Martin"=> 'en',
            "Saint Pierre and Miquelon"=> 'en',
           "Saint Vincent and the Grenadines"=> 'en',
            "Samoa"=> 'en',
             "San Marino"=> 'en',
            "Sao Tome and Principe"=> 'en',
           "Saudi Arabia"=> 'en',
             "Senegal"=> 'en',
             "Serbia and Montenegro"=> 'en',
            "Seychelles"=> 'en',
             "Sierra Leone"=> 'en',
             "Singapore"=> 'en',
           "Sint Maarten"=> 'en',
            "Slovakia"=> 'en',
             "Slovenia"=> 'en',
             "Solomon Islands"=> 'en',
             "Somalia"=> 'en',
            "South Africa"=> 'en',
             "South Georgia and the South Sandwich Islands"=> 'en',
             "South Sudan"=> 'en',
            "Sri Lanka"=> 'en',
             "Sudan"=> 'en',
            "Suriname"=> 'en',
             "Swaziland"=> 'en',
            "Sweden"=> 'en',
            "Switzerland"=> 'en',
            "Syrian Arab Republic"=> 'en',
             "Taiwan, Province of China"=> 'en',
            "Tajikistan"=> 'en',
             "Tanzania, United Republic of"=> 'en',
            "Thailand"=> 'en',
             "Timor-Leste"=> 'en',
            "Togo"=> 'en',
            "Tokelau"=> 'en',
             "Tonga"=> 'en',
           "Tunisia"=> 'en',
            "Turkey"=> 'en',
            "Turkmenistan"=> 'en',
           "Turks and Caicos Islands"=> 'en',
            "Tuvalu"=> 'en',
             "Uganda"=> 'en',
             "Ukraine"=> 'en',
            "United Arab Emirates"=> 'en',
            "United Kingdom"=> 'en',
           "United States Minor Outlying Islands"=> 'en',
             "Uruguay"=> 'en',
            "Uzbekistan"=> 'en',
           "Vanuatu"=> 'en',
            "Venezuela"=> 'en',
            "Viet Nam"=> 'en',
            "Virgin Islands, British"=> 'en',
            "Virgin Islands, U.s."=> 'en',
           "Wallis and Futuna"=> 'en',
            "Western Sahara"=> 'en',
           "Yemen"=> 'en',
           "Zambia"=> 'en',
            "Zimbabwe"=> 'en',
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
