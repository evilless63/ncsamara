<?php

namespace App\Http\Controllers;

use App\District;
use App\Profile;
use App\Promotional;
use App\Rate;
use App\Bonus;
use App\Statistic;
use App\User;
use App\Service;
use App\Appearance;
use App\Hair;
use App\Image;
use Auth;
use File;
use Illuminate\Support\Carbon;
use Transliterate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public $services;
    public $appearances;
    public $hairs;
    public $districts;
    public $bonuses;
    public $rates;

    public function __construct()
    {
        $this->middleware('auth');
        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->hairs = Hair::all();
        $this->rates = Rate::all();
        $this->bonuses = Bonus::all();
        $this->districts = District::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.profiles.index', ['profiles' => Auth::user()->profiles]);
    }

    public function adminindex()
    {
        return view('admin.profiles.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('user.profiles.create', [
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
            'districts' => $this->districts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProfile(true);

        $profileArr = request()->all();
        $profileArr['user_id'] = Auth::user()->id;

        $profile = Profile::create($profileArr);

        if(request()->filled('services')) {
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if(request()->filled('appearance')) {
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->filled('hair')) {
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if(request()->filled('district')) {
            $profile->districts()->attach(District::findOrFail(request()->district));
        }

        if(request()->filled('item_images')) {

            $array = explode(",", request()->item_images);
            foreach ($array as $arr ) {
                $image = new Image;
                $image->name = $arr;
                $image->profile_id = $profile->id;
                $image->save();
                File::move(public_path() . '/images/profiles/images/new_upload/' . $image->name, public_path() . '/images/profiles/images/created/' . $image->name);
            }

        }

        if(request()->hasFile('main_image')) {
            $_IMAGE = $request->file('main_image');
            $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());

            $uploadPath = public_path() . '/images/profiles/main/created';
            $_IMAGE->move($uploadPath,$filename);

            $profile['main_image'] = $filename;
            $profile->update();
        }

        $profile->rates()->attach(Rate::first());

        return redirect(route('user.profiles.index'))->withSuccess('Успешно создано');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('user.profiles.edit', [
            'profile' => $profile,
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
            'rates' => $this->rates,
            'districts' => $this->districts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {

        $this->validateProfile(false);

        $profileArr = request()->all();

        if (Auth::user()->is_admin) {
        } else {
            $profileArr['user_id'] = Auth::user()->id;
        }

        if(request()->filled('services')) {
            $profile->services()->detach();
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }
        $profile->update($profileArr);

        if(request()->filled('appearance')) {
            $profile->appearances()->detach();
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->filled('hair')) {
            $profile->hairs()->detach();
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if(request()->filled('district')) {
            $profile->districts()->detach();
            $profile->districts()->attach(District::findOrFail(request()->district));
        }

        if(request()->filled('item_images') && request()->item_images <> null) {
            $array = explode(",", request()->item_images);
            foreach ($array as $arr ) {
                $image = new Image;
                $image->name = $arr;
                $image->profile_id = $profile->id;
                $image->save();
                File::move(public_path() . '/images/profiles/images/new_upload/' . $image->name, public_path() . '/images/profiles/images/created/' . $image->name);
            }

        }

        if(request()->filled('rate')) {
            $profile->rates()->detach();
            $profile->rates()->attach(Rate::findOrFail(request()->rate));
        }

        if(request()->hasFile('verificate_image')) {
            $_IMAGE = $request->file('verificate_image');
            $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());

            $uploadPath = public_path() . '/images/profiles/verificate';
            $_IMAGE->move($uploadPath,$filename);

            $profile['verificate_image'] = $filename;
            $profile->update();
        }

        $_IMAGE = $request->file('main_image');

        if($_IMAGE <> null) {
            $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
            $uploadPath = public_path() . '/images/profiles/main/created';
            File::delete(public_path() . '/images/profiles/main/created' . $profile->main_image );
            $_IMAGE->move($uploadPath,$filename);

            $profile['main_image'] = $filename;
            $profile->update();
        }


        if(Auth::user()->is_admin) {
            return redirect(route('admin.adminprofiles'))->withSuccess('Успешно обновлено');
        } else {
            return redirect(route('user.profiles.index'))->withSuccess('Успешно обновлено');
        }

    }

    public function publish(Request $request, $id) {

        if(auth()->user()->is_admin) {
            $profile = Profile::where('id', $id)->firstOrFail();
        } else {
            $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        }

        $profile['is_published'] = 1;
        $profile->update();

        if(auth()->user()->is_admin) {
            return redirect(route('admin.adminprofiles'))->withSuccess('Успешно опубликована');
        } else {
            return redirect(route('user.profiles.index'))->withSuccess('Успешно опубликована');
        }
    }

    public function unpublish(Request $request, $id) {

        if(auth()->user()->is_admin) {
            $profile = Profile::where('id', $id)->firstOrFail();
        } else {
            $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        }

        $profile['is_published'] = 0;
        $profile->update();

        if(auth()->user()->is_admin) {
            return redirect(route('admin.adminprofiles'))->withSuccess('Успешно снята с публикации');
        } else {
            return redirect(route('user.profiles.index'))->withSuccess('Успешно снята с публикации');
        }


    }

    public function verify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 1;
        $profile->update();
        return redirect(route('admin.adminprofiles'))->withSuccess('Успешно подтверждена');
    }

    public function unverify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 0;
        $profile->update();
        return redirect(route('admin.adminprofiles'))->withSuccess('Успешно снята с подтверждения');
    }

    public function userbanoff(Request $request, $id) {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 0;
        $user->update();
        return redirect(route('admin.adminprofiles'))->withSuccess('Успешно забанен');
    }

    public function userbanon(Request $request, $id) {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 1;
        $user->update();
        return redirect(route('admin.adminprofiles'))->withSuccess('Успешно разбанен');
    }

    //Для крона
    public function activateJob(Request $request, $id) {
        $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = $profile->user;
        $rate = $profile->rates->first();

        if(($user->user_balance - $rate->cost) < 0) {
            $profile['is_archived'] = true;
            $profile->update();
            return redirect(route('user.payments'));
        }

        $user['user_balance'] = $user->user_balance - $rate->cost;
        $user->update();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = - $rate->cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $profile['is_archived'] = false;
        $profile['last_payment'] = Carbon::now();
        $profile['next_payment'] = Carbon::now()->addDays(1);

        $next_payment = Carbon::parse($profile->next_payment);
        $last_payment = Carbon::parse($profile->last_payment);
        $profile['minutes_to_archive'] = $next_payment->diffInMinutes($last_payment);

        $profile->update();

        return redirect(route('user.payments'));

    }

    public function activate(Request $request, $id) {
        $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = $profile->user;
        $rate = $profile->rates->first();

        if(($user->user_balance - $rate->cost) < 0) {
            $profile['is_archived'] = true;
            $profile->update();
            return redirect(route('user.payments'))->withFail('Не достаточно денег на балансе');
        }

        $user['user_balance'] = $user->user_balance - $rate->cost;
        $user->update();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = - $rate->cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $profile['is_archived'] = false;
        $profile['last_payment'] = Carbon::now();
        $profile['next_payment'] = Carbon::now()->addDays(1);

        $next_payment = Carbon::parse($profile->next_payment);
        $last_payment = Carbon::parse($profile->last_payment);
        $profile['minutes_to_archive'] = $next_payment->diffInMinutes($last_payment);

        $profile->update();

        return redirect(route('user.payments'))->withSuccess('Успешно активирована');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    protected function validateProfile($isNew = false)
    {

        if($isNew) {
            // return request()->validate([
            //     'name' => 'required',
            //     'phone' => 'required|unique:App\Profile,phone|regex:/^((8)+([0-9]){10})$/i',
            //     'about' => 'required',
            //     'district' => 'required',
    //            'address' => 'required',
    //            'address_x' => 'required',
    //            'address_y' => 'required',
                // 'working_hours' => 'required',
                // 'boobs' => 'required|integer|between:1,10',
                // 'age' => 'required|integer|between:18,65',
                // 'weight' => 'required|integer|between:40,100',
                // 'height' => 'required|integer|between:150,195',
                // 'one_hour' => 'required|integer|between:1000,50000',
                // 'two_hour' => 'required|integer|between:1000,100000',
                // 'all_night' => 'required|integer|between:1000,1000000',
            // ]);
        } else {
            // return request()->validate([
            //     'name' => 'required',
            //     'phone' => 'required|regex:/^((8)+([0-9]){10})$/i',
            //     'about' => 'required',
            //     'district' => 'required',
    //            'address' => 'required',
    //            'address_x' => 'required',
    //            'address_y' => 'required',
                // 'working_hours' => 'required',
                // 'boobs' => 'required|integer|between:1,10',
                // 'age' => 'required|integer|between:18,65',
                // 'weight' => 'required|integer|between:40,100',
                // 'height' => 'required|integer|between:150,195',
                // 'one_hour' => 'required|integer|between:1000,50000',
                // 'two_hour' => 'required|integer|between:1000,100000',
                // 'all_night' => 'required|integer|between:1000,1000000',
            // ]);
        }

    }

    public function fileUpload(Request $request)
    {
        $_IMAGE = $request->file('file');
        $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
        $uploadPath = 'images/profiles/images/new_upload';
        $_IMAGE->move($uploadPath,$filename);
        echo json_encode($filename);
    }

    public function removeUpload(Request $request)
    {

        try{
            $image = str_replace('"', '', $request->file);
            File::delete(public_path() . '/images/profiles/images/new_upload' . $image );
        }
        catch(Exception $e) {
//            echo json_encode('Message: ' .$e->getMessage());
        }
        finally{
//            $message = "success";
        }
        return json_encode($image);

    }

    public function removeCreated(Request $request)
    {

        try{
            $image = str_replace('"', '', $request->file);
            File::delete(public_path() . '/images/profiles/images/created' . $image );
        }
        catch(Exception $e) {
//            echo json_encode('Message: ' .$e->getMessage());
        }
        finally{
//            $message = "success";
        }
        return json_encode($image);

    }

    private function regexpImages($imageName) {
        return Transliterate::make(preg_replace("/[^А-Яа-яA-Za-z\d\.]/", '', $imageName));
    }

    public function payments() {
        return view('user.payments.index', [
            'profiles' => Auth::user()->profiles,
            'hairs' => $this->hairs,
            'rates' => $this->rates,
            'bonuses' => $this->bonuses,
        ]);
    }

    public function plusbonusinfo() {

        if(request()->has('payment')) {
            if(request()->payment <> null) {
                $bonus = Bonus::where('min_sum','<',request()->payment)->where('max_sum','>=', request()->payment)->first();

                if($bonus <> null) {
                    return 'Бонусы при пополнении: +' . round(request()->payment * $bonus->koef / 100) . ' Пойнтов';
                } else {
                    return '';
                }
            }
        }
    }

    public function makepayment() {
        $current_balance = Auth::user()->user_balance;

        $bonus = Bonus::where('min_sum','<',request()->payment)->where('max_sum','>=', request()->payment)->first();
        $payment = request()->payment;
        if($bonus <> null) {
            $payment = $payment + ($payment * $bonus->koef / 100);
        }

        Auth::user()->user_balance = $current_balance + $payment;
        Auth::user()->save();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = $payment;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        return redirect(route('user.payments'))->withSuccess('Успешно пополнен баланс');
    }

    public function promotionalpayment() {

        request()->validate([
            'promotionalpayment' => 'required|exists:promotionals,code'
        ]);

        $codes = Promotional::where('code', request()->promotionalpayment)->where('is_activated', false);
        if($codes->count() > 0) {
            $sum = $codes->first()->replenish_summ;
            $current_balance = Auth::user()->user_balance;
            Auth::user()->user_balance = $current_balance + $sum;
            Auth::user()->save();

            $code = Promotional::where('id', $codes->first()->id)->first();
            $code['is_activated'] = 1;

            $code->save();

            $statistic = new Statistic();
            $statistic['user_id'] = Auth::user()->id;
            $statistic['payment'] = $sum;
            $statistic['where_was'] = Carbon::now();
            $statistic->save();
            return redirect(route('user.payments'))->withSuccess('Успешно пополнен баланс');
        }
        else {
            return redirect(route('user.payments'))->withFail('Промокод не найден');
        }

    }


    public function changeServicePrice()
    {

          $profile = Profile::find(request()->profile_id);
          $service = Profile::find(request()->service_id);

            if($profile->user_id == Auth::user()->id){

                $profile->services()->detach($service);
                $profile->services()->attach(
                    $service,  ['price' => request()->price]
                );

            }
    }
}
