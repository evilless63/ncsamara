<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Salon;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.admin');
    }

    public function user()
    {
        return view('user.user',
            [
                'users' => User::all(),
                'profiles' => Profile::all(),
                'salons' => Salon::all(),
            ]
        );
    }
}
