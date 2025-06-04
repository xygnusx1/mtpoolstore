<?php

namespace App\Http\Controllers;

use Spatie\Navigation\Navigation;

abstract class Controller
{
    protected function makeNavMenu() : Navigation {
        return Navigation::make()
            ->add('/', route('home'))
            ->add('Customer', route('cust'));
//            ->add('User', route('user-props'));
    }
}

