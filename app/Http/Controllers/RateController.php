<?php

namespace App\Http\Controllers;

use App\Rate;
use Transliterate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.rates.index', ['rates' => Rate::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRate();
        $rate_data = request()->all();
        $_IMAGE = $request->file('image');
        if($_IMAGE <> null) {
        $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        $uploadPath = public_path() . '/images/rates/created';
        $_IMAGE->move($uploadPath,$filename);

        $rate_data['image'] = $filename;
        }
        Rate::create($rate_data);
        return redirect(route('admin.rates.index'))->withSuccess('Успешно создано');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        return view('admin.rates.edit', ['rate' => $rate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        $this->validateRate();
        $rate_data = request()->all();
//        Rate::update($this->validateRate());

    
            $_IMAGE = $request->file('image');
            if($_IMAGE <> null) {
            $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
            $uploadPath = public_path() . '/images/rates/created';
            File::delete(public_path() . '/images/rates/created' . $rate->image );
            $_IMAGE->move($uploadPath,$filename);

            $rate_data['image'] = $filename;
    }
        $rate->update($rate_data);

        return redirect(route('admin.rates.index'))->withSuccess('Успешно обновлено');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }

    private function validateRate() {
        return request()->validate([
            'name' => 'required',
            'description' => 'required',
//            'image' => 'required',
            'cost' => 'integer|required'
        ]);
    }

    private function regexpImages($imageName) {
        return Transliterate::make(preg_replace("/[^A-Za-z\d\.]/", '', $imageName));
    }
}
