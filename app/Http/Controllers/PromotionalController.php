<?php

namespace App\Http\Controllers;

use App\Promotional;
use Illuminate\Http\Request;

class PromotionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promotionals.index', ['promotionals' => Promotional::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promotionals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Promotional::create($this->promotionalValidate());
        return view('admin.promotionals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotional  $promotional
     * @return \Illuminate\Http\Response
     */
    public function show(Promotional $promotional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotional  $promotional
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotional $promotional)
    {
        return view('admin.promotionals.edit', ['promotional' => $promotional]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotional  $promotional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotional $promotional)
    {
        $promotional->update($this->promotionalValidate());
        return view('admin.promotionals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotional  $promotional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotional $promotional)
    {

    }

    private function promotionalValidate() {
        return request()->validate([
            'code' => 'required',
            'replenish_summ' => 'integer|required',
        ]);
    }
}
