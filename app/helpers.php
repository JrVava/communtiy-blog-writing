<?php

use App\Models\Country;

if (!function_exists('countries')) {
    function countries()
    {
        return Country::get();
    }
}
