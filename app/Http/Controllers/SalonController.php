<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Salon;
use App\User;
use Auth;
use Transliterate;
use File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        if(Auth::user()->salon()->get()->count() > 0) {
            return view('user.salons.edit', ['salon' => Auth::user()->salon()->first()]);
        } else {
            return view('user.salons.create');
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
        $salon_data = $this->validateSalon();
        $salon_data['user_id'] = Auth::user()->id;

        $_IMAGE = $request->file('image');
        $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        $uploadPath = public_path() . '/images/salons/created';
        $_IMAGE->move($uploadPath,$filename);

        $salon_data['image'] = $filename;

        Salon::create($salon_data);
        return view('user.user');
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
        $salon_data = $this->validateSalon();
        $salon_data['user_id'] = Auth::user()->id;

        $_IMAGE = $request->file('image');
        $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        $uploadPath = public_path() . '/images/salons/created';
        File::delete(public_path() . '/images/salons/created' . $salon->image );
        $_IMAGE->move($uploadPath,$filename);

        $salon_data['image'] = $filename;

        $salon->update($salon_data);
        return view('user.user');
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
        return view('user.user');

    }

    private function validateSalon() {
        return request()->validate([
            'name' => 'required',
            'address' => 'required',
            'image' => [
                    'required',
                    Rule::dimensions()->maxWidth(1500)->maxHeight(1000)->ratio(3/2),
                ],
            'phone' => 'required|unique:App\Salon,phone|regex:/^((\d)+([0-9]){10})$/i',
        ]);
    }

    private function regexpImages($imageName) {
        return Transliterate::make(preg_replace("/[^А-Яа-яA-Za-z\d\.]/", '', $imageName));
    }
}
