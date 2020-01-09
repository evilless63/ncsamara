<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Salon;
use App\User;
use Auth;
use Illuminate\Http\Request;

class SalonController extends Controller
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
        if(Auth::user()->salon()->get()) {
            return route('user.salons.edit', Auth::user()->salon()->get()->id);
        } else {
            return route('user.salon.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.salons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Profile::create($this->validateSalon());
        return route('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function show(Salon $salon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function edit(Salon $salon)
    {
        return view('user.salons.edit', ['salon' => $salon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salon $salon)
    {
        $salon->update($this->validateSalon());
        return route('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salon $salon)
    {
        $salon->delete();
        return route('user');

    }

    private function validateSalon() {
        return request()->validate([
            'name' => 'required',
            'address' => 'required',
            'image' => [
                    'required',
                    Rule::dimensions()->maxWidth(1000)->maxHeight(500)->ratio(3 / 2),
                ],
            'phone' => 'required|unique:App\Salon,phone|regex:/^((\d)+([0-9]){10})$/i',
        ]);
    }
}
