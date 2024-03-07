<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;


    if(! function_exists('denemeUser')) {
        function denemeUser()
        {
            if(Auth::check()){
                !empty(Auth::user())
                ? 'User geldi'
                : 'gelen giden yok';
            }
        }
    }