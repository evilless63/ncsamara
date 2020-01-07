<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use App\Service;
use App\Appearance;
use App\Hair;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public $services;
    public $appearances;
    public $hairs;

    public function __construct()
    {
        $this->middleware('auth');
        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->hairs = Hair::all();
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
        return view('user.profiles.create', [
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $profile = Profile::create($this->validateProfile(true));

        if(request()->has('services')) {
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if(request()->has('appearance')) {
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->has('hair')) {
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
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
        return view('user.profiles.edit', [
            'profile' => $profile,
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
        ]);
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
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if(request()->has('appearance')) {
            $profile->appearances()->detach();
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->has('hair')) {
            $profile->hairs()->detach();
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
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
            'working_hours' => 'required',
            'boobs' => 'required|integer|between:1,10',
            'age' => 'required|integer|between:18,65',
            'weight' => 'required|integer|between:40,100',
            'height' => 'required|integer|between:150,195',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
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
            'working_hours' => 'required',
            'boobs' => 'required|integer|between:1,10',
            'age' => 'required|integer|between:18,65',
            'weight' => 'required|integer|between:40,100',
            'height' => 'required|integer|between:150,195',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
        ]);
    }
}
