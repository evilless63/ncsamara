<?php

namespace App\Http\Controllers;

use App\Salonrate;
use Transliterate;
use Illuminate\Http\Request;
use App\Bonus;

class RateController extends Controller
{

    public $bonuses;

    public function __construct()
    {
        $this->bonuses = Bonus::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.salonrates.index', [
            'rates' => Salonrate::all(),
            'bonuses' => $this->bonuses
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.salonrates.create', ['bonuses' => $this->bonuses]);
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
        Salonrate::create($rate_data);
        return redirect(route('admin.salonrates.index'))->withSuccess('Успешно создано');;
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
        return view('admin.salonrates.edit', [
            'rate' => $rate,
            'bonuses' => $this->bonuses
            ]);
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
        $rate->update($rate_data);

        return redirect(route('admin.salonrates.index'))->withSuccess('Успешно обновлено');;
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
            'cost' => 'integer|required'
        ]);
    }
}
