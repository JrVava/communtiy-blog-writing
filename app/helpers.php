<?php

use App\Models\Country;

if (!function_exists('countries')) {
    function countries()
    {
        return Country::get();
    }
}

if (!function_exists('adminAssetPath')) {
    function adminAssetPath()
    {
        if (env('APP_ENV') == 'local') {
            return 'assets/';
        } else {
            return 'public/assets/';
        }
    }
}
if (!function_exists('userAssetPath')) {
    function userAssetPath()
    {
        if (env('APP_ENV') == 'local') {
            return 'assets/';
        } else {
            return 'public/assets/';
        }
    }
}
