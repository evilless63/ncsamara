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
        return view('user.salons.index', ['salons' => Auth::user()->salons(), 'rates' => $this->rates, 'bonuses' => $this->bonuses]);
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
            && ( ($request->has('image') && $salon->image <> $request->image) ||
                ($request->has('name') && $salon->name <> $request->name) )) {

            $salon_data = Arr::add($salon_data, 'allowed', 0);

                if($salon->is_published) {
                    $salon->was_published = true;
                    $this->unpublish($salon->id);
                }
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

        if($salon->was_published) {
            $salon->was_published = false;
            $this->publish($request, $id);
        }

        return back()->withSuccess('Успешно разрешен к публикации');
    }

    public function moderatedisallow(Request $request, $id) {
        $salon = Salon::where('id', $id)->firstOrFail();
        $salon['allowed'] = 0;

        if($salon->is_published) {
            $salon->was_published = true;
            $this->unpublish($salon->id);
        }

        $salon->update();
        return back()->withSuccess('Успешно запрещен к публикации');
    }

    public function publish(Request $request, $id)
    {

        if (auth()->user()->is_admin) {
            $salon = Salon::where('id', $id)->firstOrFail();

            $salon['is_published'] = 1;
            $salon->update();

            return back()->withSuccess('Успешно опубликован');

        } else {
            $salon = Salon::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
            $this->activate($request, $id);

            if ($salon->is_published) {
                return back()->withSuccess('Успешно оплачен и опубликован');
            } else {
                return back()->withSuccess('Недостаточно средств на балансе !');
            }
        }

    }

    public function unpublish($id, $is_cron = false)
    {

        $salon = Salon::where('id', $id)->firstOrFail();
        if (auth()->user()->is_admin) {

            $salon['is_published'] = false;

        } else {

                if (!$is_cron) {
                    $user = $salon->user;
                    $rate = $salon->rates->first();
                    $hour = Carbon::now()->timezone(Config::get('app.timezone'))->format('H');
                    $cost = ($rate->cost / 24 * (24 - $hour));
                    $user['user_balance'] = $user->user_balance + $cost;
                    $user->update();
                }

                $salon['is_published'] = false;
                
        }

        $salon->update();
        return back()->withSuccess('Успешно снят с публикации');

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

        $salon = Salon::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = $salon->user;

        if ($user->is_admin) {
            return;
        }

        $rate = $salon->rates->first();
        $hour = Carbon::now()->timezone(Config::get('app.timezone'))->format('H');

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
