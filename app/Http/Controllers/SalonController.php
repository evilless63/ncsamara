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
        return view('user.salon.index', ['salons' => Auth::user()->salons(), 'rates' => $this->rates, 'bonuses' => $this->bonuses])
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
        $salon_data = request()->all()->toArray();
        $salon_data['user_id'] = Auth::user()->id;

        $salon_data['image'] = str_replace('"', '', request()->image);

        if(Auth::user()->is_admin == false) {
            // $salon_data = Arr::add($salon_data, 'on_moderate', 1);
            $salon_data = Arr::add($salon_data, 'allowed', 0);
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
        if($request->has('image')){    
            $salon_data['image'] = str_replace('"', '', request()->image);
        }

        if(Auth::user()->is_admin == false
            && ( 
                ($request->has('image') && $salon->image <> $request->image) ||
                ($request->has('name') && $salon->name <> $request->name) || 
                
            )
        ) {


            // $salon_data = Arr::add($salon_data, 'on_moderate', 1);
            $salon_data = Arr::add($salon_data, 'allowed', 0);
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

    private function regexpImages($imageName) {
        return Transliterate::make(preg_replace("/[^A-Za-z\d\.]/", '', $imageName));
    }

    public function moderateallow(Request $request, $id) {
        $salon = Salon::where('id', $id)->firstOrFail();
        $salon['allowed'] = 0;
        $salon->update();
        return back()->withSuccess('Успешно разрешен к публикации');
    }

    public function moderatedisallow(Request $request, $id) {
        $salon = Salon::where('id', $id)->firstOrFail();
        $salon['allowed'] = 0;
        $salon->update();
        return back()->withSuccess('Успешно запрещена к публикации');
    }
}
