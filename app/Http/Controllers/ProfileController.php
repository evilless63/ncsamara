<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.profiles.index', ['profiles' => Auth::user()->profiles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $profile = Profile::create($this->validateProfile(true));

        if(request()->has('services')) {
            $profile->services()->attach(request('services'));
        }

        return redirect(route('user.profiles.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('user.profiles.edit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $profile->update($this->validateProfile(false));

        if(request()->has('services')) {
            $profile->services()->detach();
            $profile->services()->attach(request('services'));
        }

        return redirect(route('user.profiles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    protected function validateProfile($isNew = false)
    {

        if ($isNew) {
            $this->newValidate();
        } else {
            $this->oldValidate();
        }

        $profileArr = request()->all();
        if (Auth::user()->is_admin && !$isNew) {
        } else {
            $profileArr['user_id'] = Auth::user()->id;
        }

        return $profileArr;
    }

    protected function newValidate()
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|unique:App\Profile,phone|regex:/^((8)+([0-9]){10})$/i',
            'about' => 'required',
            'address' => 'required',
            'address_x' => 'required',
            'address_y' => 'required',
            'working_hours' => 'required'
        ]);
    }

    protected function oldValidate()
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|regex:/^((8)+([0-9]){10})$/i',
            'about' => 'required',
            'address' => 'required',
            'address_x' => 'required',
            'address_y' => 'required',
            'working_hours' => 'required'
        ]);
    }
}
