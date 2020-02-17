<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Salon;
use App\User;
use App\Rate;
use Auth;
use Transliterate;
use File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Bonus;

class SalonController extends Controller
{

    public $rates;
    public $bonuses;

    public function __construct()
    {
        $this->middleware('auth');
        $this->rates = Rate::where('for_salons', 1)->get();
        $this->bonuses = Bonus::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->salon()->get()->count() > 0) {
            return view('user.salons.edit', ['salon' => Auth::user()->salon()->first(), 'rates' => $this->rates, 'bonuses' => $this->bonuses]);
        } else {
            return view('user.salons.create', ['bonuses' => $this->bonuses]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.salons.create', ['bonuses' => $this->bonuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateSalon(true);
        $salon_data = request()->all();
        $salon_data['user_id'] = Auth::user()->id;

        // $_IMAGE = $request->file('image');
        // $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        // $uploadPath = public_path() . '/images/salons/created';
        // $_IMAGE->move($uploadPath,$filename);

        $salon_data['image'] = str_replace('"', '', request()->image);

        // $_IMAGE2 = $request->file('image_prem');
        // if($_IMAGE2 <> null) {
        //     $filename2 = $this->regexpImages(time().$_IMAGE2->getClientOriginalName());
        //     $uploadPath = public_path() . '/images/salons/created';
        //     $_IMAGE2->move($uploadPath,$filename2);

        //     $salon_data['image_prem'] = $filename2;
        // }
        if($request->has('image_prem')){
            $salon_data['image_prem'] = str_replace('"', '', request()->image_prem);
        }
        

        Salon::create($salon_data);
        return redirect(route('user.salons.index'))->withSuccess('Успешно создано');
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
        dd($this->rates);
        return view('user.salons.edit', [
            'salon' => $salon,
            'rates' => $this->rates,
            'bonuses' => $this->bonuses
            ]);
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
        
        $this->validateSalon(false);
        $salon_data = request()->all();
  
        $salon_data['user_id'] = Auth::user()->id;

        $_IMAGE = $request->file('image');
        
        // if($_IMAGE <> null) {
        //     $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        //     $uploadPath = public_path() . '/images/salons/created';
        //     File::delete(public_path() . '/images/salons/created' . $salon->image );
        //     $_IMAGE->move($uploadPath,$filename);

        //     $salon_data['image'] = $filename;

        // }

        // $_IMAGE2 = $request->file('image_prem');
        // if($_IMAGE2 <> null) {
        //     $filename2 = $this->regexpImages(time().$_IMAGE2->getClientOriginalName());
        //     $uploadPath = public_path() . '/images/salons/created';
        //     $_IMAGE2->move($uploadPath,$filename2);

        //     $salon_data['image_prem'] = $filename2;
        // }
        if($request->has('image')){    
        $salon_data['image'] = str_replace('"', '', request()->image);
        }

        if($request->has('image_prem')){
            $salon_data['image_prem'] = str_replace('"', '', request()->image_prem);
        }

        $salon->update($salon_data);

        if(request()->filled('rate')) {
            $salon->rates()->detach();
            $salon->rates()->attach(Rate::findOrFail(request()->rate));
        }
        
        return back()->withSuccess('Успешно обновлено');
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
        return back()->withSuccess('Успешно удалено');

    }

    private function validateSalon($isNew) {

        if($isNew) {
            return request()->validate([
                'name' => 'required',
                // 'address' => 'required',
                'image' => 'required',
                'phone' => 'required|unique:App\Salon,phone|regex:/^((\d)+([0-9]){10})$/i',
            ]);
        } else {
            return request()->validate([
                'name' => 'required',
                // 'address' => 'required',
                'image' => 'required',
                'phone' => 'required|regex:/^((\d)+([0-9]){10})$/i',
            ]); 
        }
        
    }

    public function fileUpload(Request $request)
    {
        $_IMAGE = $request->file('image');
        $filename = $this->regexpImages(str_replace('"', '', time().$_IMAGE->getClientOriginalName()));
        $uploadPath = 'images/salons/created';
        $_IMAGE->move($uploadPath,str_replace('"', '', $filename));
        echo json_encode($filename);
    }

    public function fileUploadSlider(Request $request)
    {
        $_IMAGE = $request->file('image_prem');
        $filename = $this->regexpImages(str_replace('"', '', time().$_IMAGE->getClientOriginalName()));
        $uploadPath = 'images/salons/created';
        $_IMAGE->move($uploadPath,str_replace('"', '', $filename));
        echo json_encode($filename);
    }


    private function regexpImages($imageName) {
        return Transliterate::make(preg_replace("/[^A-Za-z\d\.]/", '', $imageName));
    }
}
