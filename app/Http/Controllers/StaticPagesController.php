<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function aboutUs(){
        return view('static.about-us');
    }
    public function termsAndConditions(){
        return view('static.terms-and-conditions');
    }
}
