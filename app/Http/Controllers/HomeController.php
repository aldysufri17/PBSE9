<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function indexAdmin()
    {
        return view('backend.dashboard');
    }

    public function indexPengguna()
    {
        return view('frontend.home');
    }
}
