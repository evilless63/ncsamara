<?php

namespace App\Http\Controllers;

use App\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
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
        return view('admin.bonuses.index', ['bonuses' => Bonus::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bonuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'min_sum' => 'integer|required',
            'koef' => 'numeric|required',
        ]);

        Bonus::create(request()->all());

        return redirect(route('admin.bonuses.index'))->withSuccess('Успешно создано');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bonus $bonus)
    {
        return view('admin.bonuses.edit', ['bonus' => $bonus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bonus $bonus)
    {
        request()->validate([
            'min_sum' => 'integer|required',
            'koef' => 'numeric|required',
        ]);
        $bonus->update(request()->all());
        return redirect(route('admin.bonuses.index'))->withSuccess('Успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bonus $bonus)
    {
        $bonus->delete();
        return redirect(route('admin.bonuses.index'))->withSuccess('Успешно удалено');
    }

}
