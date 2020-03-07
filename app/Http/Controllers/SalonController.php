<?php

namespace App\Http\Controllers;

use App\Bonus;
use App\Salonrate;
use App\Salon;
use App\Statistic;
use App\User;
use Arr;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Transliterate;

class SalonController extends Controller
{

    public $salonrates;
    public $bonuses;

    public function __construct()
    {
        $this->middleware('auth');
        $this->salonrates = Salonrate::all();
        $this->bonuses = Bonus::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.salons.index',
            [
                'salons' => Auth::user()->salons()->get(),
                'salonrates' => $this->salonrates,
                'bonuses' => $this->bonuses]
        );
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
        $salon_data = request()->toArray();
        $salon_data['user_id'] = Auth::user()->id;
        $salon_data['image'] = str_replace('"', '', request()->image);

        if (Auth::user()->is_admin == false) {
            $salon_data = Arr::add($salon_data, 'allowed', 0);
        } else {
            $salon_data = Arr::add($salon_data, 'allowed', 1);
        }

        $salon = Salon::create($salon_data);

        $salon->salonrates()->attach(Salonrate::first());
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
        if(Auth::user()->is_admin == 0) {
            if($salon->user_id != Auth::user()->id) {
                return back()->withSuccess('Нельзя редактировать чужие анкеты !');
            }
        }

        return view('user.salons.edit', [
            'salon' => $salon,
            'salonrates' => $this->salonrates,
            'bonuses' => $this->bonuses,
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

        
        if ($request->has('image')) {
            $salon_data['image'] = str_replace('"', '', request()->image);
        }

        if (Auth::user()->is_admin == false
            && (($request->has('image') && $salon->image != $request->image) ||
                ($request->has('name') && $salon->name != $request->name))) {

            $salon_data['user_id'] = Auth::user()->id;        
            $salon_data = Arr::add($salon_data, 'allowed', 0);

            if ($salon->is_published) {
                $salon->was_published = true;
                $this->unpublish($salon->id);
            }
        }

        $salon->update($salon_data);

        if (request()->filled('salonrate')) {
            $salon->salonrates()->detach();
            $salon->salonrates()->attach(Salonrate::findOrFail(request()->salonrate));
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
        return view('user.salons.index',
            [
                'salons' => Auth::user()->salons()->get(),
                'salonrates' => $this->salonrates,
                'bonuses' => $this->bonuses]
        )->withSuccess('Успешно удалено');
    }

    private function validateSalon($isNew)
    {

        if ($isNew) {
            return request()->validate([
                'name' => 'required',
                'image' => 'required',
                'phone' => 'required|unique:App\Salon,phone',
            ]);
        } else {
            return request()->validate([
                'name' => 'required',
                'image' => 'required',
                'phone' => 'required',
            ]);
        }

    }

    public function fileUpload(Request $request)
    {
        $_IMAGE = $request->file('image');
        $filename = $this->regexpImages(str_replace('"', '', time() . $_IMAGE->getClientOriginalName()));
        $uploadPath = 'images/salons/created';
        $_IMAGE->move($uploadPath, str_replace('"', '', $filename));
        echo json_encode($filename);
    }

    private function regexpImages($imageName)
    {
        return Transliterate::make(preg_replace("/[^A-Za-z\d\.]/", '', $imageName));
    }

    public function moderateallow(Request $request, $id)
    {
        $salon = Salon::where('id', $id)->firstOrFail();
        $salon['allowed'] = 1;
        $salon->update();

        $salon = Salon::where('id', $id)->firstOrFail();
        if ($salon->was_published) {
            $salon->was_published = false;
            $salon->update();
            $this->publish($request, $id, true);
        }

        return back()->withSuccess('Успешно разрешен к публикации');
    }

    public function moderatedisallow(Request $request, $id)
    {
        $salon = Salon::where('id', $id)->firstOrFail();
        $salon['allowed'] = 0;

        if ($salon->is_published) {
            $salon->was_published = true;
            $salon->update();
            $this->unpublish($salon->id,false,true);
        }

        $salon->update();
        return back()->withSuccess('Успешно запрещен к публикации');
    }

    public function publish(Request $request, $id, $moderation = false)
    {

        $salon = Salon::where('id', $id)->firstOrFail();
        if (auth()->user()->is_admin
            && (auth()->user()->salons()->where('id', $salon->id)->count() > 0)) {

            $salon['is_published'] = 1;
            $salon->update();

            return back()->withSuccess('Успешно опубликован');

        } else {

            if ($salon->salonrates->count() > 0) {
                $this->activate($request, $id);
            } else {
                return back()->withSuccess('Сначала выберите тариф !');
            }

            $salon = Salon::where('id', $id)->firstOrFail();

            if($moderation){

            } else {
                if ($salon->is_published) {
                    return back()->withSuccess('Успешно оплачен и опубликован');
                } else {
                    return back()->withSuccess('Недостаточно средств на балансе !');
                }
            }
        }

    }

    public function unpublish($id, $is_cron = false, $moderation = false)
    {

        $salon = Salon::where('id', $id)->firstOrFail();
        if (auth()->user()->is_admin
            && (auth()->user()->salons()->where('id', $salon->id)->count() > 0)) {

            $salon['is_published'] = false;

        } else {

            if (!$is_cron) {
                $user = $salon->user;
                $rate = $salon->salonrates->first();
                $hour = Carbon::now()->timezone(config('app.timezone'))->format('H');
                $cost = ($rate->cost / 24 * (24 - $hour));
                $user['user_balance'] = $user->user_balance + $cost;
                $user->update();
            }

            $salon['is_published'] = false;

        }

        $salon->update();

        if($moderation){

        } else {
            return back()->withSuccess('Успешно снят с публикации');
        }
        

    }

    //Для крона
    public function activateCron()
    {
        $salons = Salon::where('is_published', '1')->where('allowed', '1')->get();

        foreach ($salons as $salon) {
            $this->activate($salon->id, true);
        }
    }

    public function activate(Request $request = null, $id, $is_cron = false)
    {

        $salon = Salon::where('id', $id)->firstOrFail();
        $user = $salon->user;

        if ($user->is_admin) {
            return;
        }

        $rate = $salon->salonrates->first();
        $hour = Carbon::now()->timezone(config('app.timezone'))->format('H');

        if ($is_cron) {
            $cost = $rate->cost;
        } else {
            $cost = ($rate->cost / 24 * (24 - $hour));
        }

        if (($user->user_balance - $cost) < 0) {
            $this->unpublish($id, $is_cron);
            return;
        }

        $user['user_balance'] = $user->user_balance - $cost;
        $user->update();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = $cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $salon['is_published'] = true;

        $salon->update();

    }
}
