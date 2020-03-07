<?php

namespace App\Http\Controllers;

use App\Appearance;
use App\Bonus;
use App\District;
use App\Hair;
use App\Image;
use App\Profile;
use App\Promotional;
use App\Rate;
use App\Salon;
use App\Service;
use App\Statistic;
use App\User;
use Auth;
use File;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Transliterate;

class ProfileController extends Controller
{

    public $services;
    public $appearances;
    public $hairs;
    public $districts;
    public $bonuses;
    public $rates;
    public $salons;

    public function __construct()
    {
        $this->middleware('auth');
        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->hairs = Hair::all();
        $this->rates = Rate::all();
        $this->bonuses = Bonus::all();
        $this->districts = District::all();
        $this->salons = Salon::where('user_id', Auth::user())->get();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.profiles.index', [
            'profiles' => Auth::user()->profiles,
            'salons' => Auth::user()->salons,
            'bonuses' => $this->bonuses,
            'rates' => $this->rates,
        ]);
    }

    public function adminindex()
    {
        return view('admin.profiles.index', [
            'users' => User::all(),
            'bonuses' => $this->bonuses,
            'rates' => $this->rates,
            'profiles' => Profile::all(),
            'salons' => Salon::all(),
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
            'bonuses' => $this->bonuses,
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:App\Profile,phone',
            'about' => 'required',
            'district' => 'required',
            'boobs' => 'required|integer|between:1,7',
            'age' => 'required|integer|between:18,75',
            'weight' => 'required|integer|between:40,200',
            'height' => 'required|integer|between:130,210',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
        ]);

        $errString = "Не заполнены, или заполнены не правильно поля:";
        if ($validator->fails()) {

            foreach ($validator->errors()->all() as $error => $val) {
                $errString = $errString . ", \n" . $val;
            }

            return redirect(route('user.profiles.create'))
                ->withErrors($errString)
                ->withInput();
        }

        $profileArr = request()->toArray();

        if (Auth::user()->is_admin) {
            $profileArr = Arr::add($profileArr, 'allowed', 1);
            // $profileArr = Arr::add($profileArr, 'on_moderate', 0);
        } else {
            // $profileArr = Arr::add($profileArr, 'on_moderate', 1);
            $profileArr = Arr::add($profileArr, 'allowed', 0);
        }

        $profileArr['user_id'] = Auth::user()->id;

        $profile = Profile::create($profileArr);

        if (request()->filled('services')) {
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if (request()->filled('appearance')) {
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if (request()->filled('hair')) {
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if (request()->filled('district')) {
            $profile->districts()->attach(District::findOrFail(request()->district));
        }

        if (request()->filled('item_images')) {
            $array = explode(",", request()->item_images);
            foreach ($array as $arr) {
                $image = new Image;
                $image->name = str_replace('"', '', $arr);
                $image->profile_id = $profile->id;
                $image->save();
            }
        }

        if (request()->filled('item_images_verification') && request()->item_images_verification != null) {
            $array = explode(",", request()->item_images_verification);
            foreach ($array as $arr) {
                $image = new Image;
                $image->name = str_replace('"', '', $arr);
                $image->verification_img = true;
                $image->profile_id = $profile->id;
                $image->save();
            }
        }

        if (request()->has('main_image')) {
            $profile['main_image'] = str_replace('"', '', request()->main_image);
            $profile->update();
        }

        $profile->rates()->attach(Rate::first());

        // return redirect(route('user.profiles.index'))->withSuccess('Успешно создано');
        return redirect(route('user.profiles.edit', $profile->id))->with('just_created', true)->withSuccess('Успешно создано. Теперь вы можете дополнительно указать услуги');
        // TODO: При созданиии, автоматически переключаться на услуги

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
        if(!Auth::user()->is_admin) {
            if($profile->user_id != Auth::user()->id) {
                return back()->withSuccess('Нельзя редактировать чужие анкеты !');
            }
        }

        return view('user.profiles.edit', [
            'profile' => $profile,
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
            'rates' => $this->rates,
            'districts' => $this->districts,
            'bonuses' => $this->bonuses,
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'about' => 'required',
            'district' => 'required',
            'boobs' => 'required|integer|between:1,7',
            'age' => 'required|integer|between:18,75',
            'weight' => 'required|integer|between:40,200',
            'height' => 'required|integer|between:130,210',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
        ]);

        $errString = "Не заполнены, или заполнены не правильно поля:";
        if ($validator->fails()) {

            foreach ($validator->errors()->all() as $error => $val) {
                $errString = $errString . ", \n" . $val;
            }

            return redirect(route('user.profiles.edit', $profile->id))
                ->withErrors($errString)
                ->withInput();
        }

        $profileArr = request()->toArray();

        if (Auth::user()->is_admin == false) {
            $profileArr['user_id'] = Auth::user()->id;

            if ((request()->filled('item_images') && request()->item_images != null) ||
                ($request->has('main_image') && $profile->main_image != $request->main_image) ||
                ($request->has('name') && $profile->name != $request->name) ||
                ($request->has('about') && $profile->about != $request->about)) {

                // $profileArr = Arr::add($profileArr, 'on_moderate', 1);
                $profileArr = Arr::add($profileArr, 'allowed', 0);

                if ($profile->is_published) {
                    $profile->was_published = true;
                    $this->unpublish($profile->id);
                }
            }
        }

        // if (request()->filled('services')) {
        //     $profile->services()->detach();
        //     foreach (request('services') as $service) {
        //         $profile->services()->attach(Service::findOrFail($service));
        //     }
        // }
        $profile->update($profileArr);

        if (request()->filled('appearance')) {
            $profile->appearances()->detach();
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if (request()->filled('hair')) {
            $profile->hairs()->detach();
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if (request()->filled('district')) {
            $profile->districts()->detach();
            $profile->districts()->attach(District::findOrFail(request()->district));
        }

        if (request()->filled('item_images') && request()->item_images != null) {
            $array = explode(",", request()->item_images);
            foreach ($array as $arr) {
                $image = new Image;
                $image->name = str_replace('"', '', $arr);
                $image->profile_id = $profile->id;
                $image->save();
            }
        }

        if (request()->filled('item_images_verification') && request()->item_images_verification != null) {
            $array = explode(",", request()->item_images_verification);
            foreach ($array as $arr) {
                $image = new Image;
                $image->name = str_replace('"', '', $arr);
                $image->verification_img = true;
                $image->profile_id = $profile->id;
                $image->save();
            }
        }

        if (request()->filled('rate')) {
            $profile->rates()->detach();
            $profile->rates()->attach(Rate::findOrFail(request()->rate));
        }

        if ($request->has('main_image')) {

            $profile['main_image'] = str_replace('"', '', request()->main_image);
            $profile->update();
        }

        return back()->withSuccess('Успешно обновлено');

    }

    public function publish(Request $request, $id, $moderation = false)
    {

        $profile = Profile::where('id', $id)->firstOrFail();
        if (auth()->user()->is_admin
            && (auth()->user()->profiles()->where('id', $profile->id)->count() > 0)) {

            $profile['is_published'] = 1;
            $profile->update();

            return back()->withSuccess('Успешно опубликована');

        } else {

            if ($profile->rates->count() > 0) {
                $this->activate($request, $id);
            } else {
                return back()->withSuccess('Сначала выберите тариф !');
            }
            $profile = Profile::where('id', $id)->firstOrFail();

            if ($moderation) {

            } else {
                if ($profile->is_published) {
                    return back()->withSuccess('Успешно оплачена и опубликована');
                } else {
                    return back()->withSuccess('Недостаточно средств на балансе !');
                }
            }
        }

    }

    public function unpublish($id, $is_cron = false, $moderation = false)
    {

        $profile = Profile::where('id', $id)->firstOrFail();
        if (auth()->user()->is_admin) {

            $profile['is_published'] = false;

        } else {

            if (!$is_cron) {
                $user = $profile->user;
                $rate = $profile->rates->first();
                $hour = Carbon::now()->timezone(config('app.timezone'))->format('H');
                $cost = ($rate->cost / 24 * (24 - $hour));
                $user['user_balance'] = $user->user_balance + $cost;
                $user->update();
            }

            $profile['is_published'] = false;

        }

        $profile->update();
        if ($moderation) {

        } else {
            return back()->withSuccess('Успешно снята с публикации');
        }
    }

    public function verify(Request $request, $id)
    {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 1;
        $profile->update();
        return back()->withSuccess('Успешно подтверждена');
    }

    public function unverify(Request $request, $id)
    {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 0;
        $profile->update();
        return back()->withSuccess('Успешно снята с подтверждения');
    }

    public function moderateallow(Request $request, $id)
    {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['allowed'] = 1;
        $profile->update();

        if ($profile->was_published) {
            $profile->was_published = false;
            $profile->update();
            $this->publish($request, $id, true);
        }

        return back()->withSuccess('Успешно разрешена к публикации');
    }

    public function moderatedisallow(Request $request, $id)
    {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['allowed'] = 0;

        if ($profile->is_published) {
            $profile->was_published = true;
            $profile->update();
            $this->unpublish($profile->id, false, true);
        }

        $profile->update();
        return back()->withSuccess('Успешно запрещена к публикации');
    }

    public function userbanoff(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 0;
        $user->update();
        return back()->withSuccess('Успешно забанен');
    }

    public function userbanon(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 1;
        $user->update();
        return back()->withSuccess('Успешно разбанен');
    }

    //Для крона
    public function activateCron()
    {
        $profiles = Profile::where('is_published', '1')->where('allowed', '1')->get();

        foreach ($profiles as $profile) {
            $this->activate(null, $profile->id, true);
        }
    }

    public function activate(Request $request = null, $id, $is_cron = false)
    {

        $profile = Profile::where('id', $id)->firstOrFail();
        $user = $profile->user;

        if ($user->is_admin) {
            return;
        }

        $rate = $profile->rates->first();
        $hour = Carbon::now()->timezone(config('app.timezone'))->format('H');

        // TODO округление дроби в нашу пользу
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
        $statistic['user_id'] = $user->id;
        $statistic['payment'] = $cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $profile['is_published'] = true;

        $profile->update();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return back()->withSuccess('Успешно удалено');
    }

    protected function validateProfile($isNew = false)
    {

        if ($isNew) {
            return $this->validate(request(), [
                'name' => 'required',
                'phone' => 'required|unique:App\Profile,phone',
                'about' => 'required',
                'district' => 'required',
                'boobs' => 'required|integer|between:1,10',
                'age' => 'required|integer|between:18,65',
                'weight' => 'required|integer|between:40,100',
                'height' => 'required|integer|between:150,195',
                'one_hour' => 'required|integer|between:1000,50000',
                'two_hour' => 'required|integer|between:1000,100000',
                'all_night' => 'required|integer|between:1000,1000000',
            ]);
        } else {
            return $this->validate(request(), [
                'name' => 'required',
                'phone' => 'required',
                'about' => 'required',
                'district' => 'required',
                'boobs' => 'required|integer|between:1,10',
                'age' => 'required|integer|between:18,65',
                'weight' => 'required|integer|between:40,100',
                'height' => 'required|integer|between:150,195',
                'one_hour' => 'required|integer|between:1000,50000',
                'two_hour' => 'required|integer|between:1000,100000',
                'all_night' => 'required|integer|between:1000,1000000',
            ]);
        }

    }

    public function fileUpload(Request $request)
    {
        $_IMAGE = $request->file('file');
        $filename = $this->regexpImages(str_replace('"', '', time() . $_IMAGE->getClientOriginalName()));
        $uploadPath = 'images/profiles/images/created';
        $_IMAGE->move($uploadPath, str_replace('"', '', $filename));
        echo json_encode($filename);
    }

    public function removeUpload(Request $request)
    {

        try {
            $image = str_replace('"', '', $request->file);
            File::delete(public_path() . '/images/profiles/images/created' . $image);
        } catch (Exception $e) {
        } finally {
        }
        return json_encode($image);

    }

    public function removeCreated(Request $request)
    {

        try {
            $image = str_replace('"', '', $request->file);
            File::delete(public_path() . '/images/profiles/images/created' . $image);
        } catch (Exception $e) {
        } finally {
        }
        return json_encode($image);

    }

    private function regexpImages($imageName)
    {
        return preg_replace("/[^A-Za-z\d\.]/", '', Transliterate::make($imageName));
    }

    public function payments()
    {

        $salon_summ = 0;
        if(Auth::user()->is_admin) {
            $salons = Salon::where('is_published', '1')->get();
        } else {
            $salons = Salon::where('is_published', '1')->where('user_id', Auth::user()->id)->get();
        }
        
        foreach($salons as $salon) {
           $salon_summ = $salon_summ  +  $salon->salonrates()->first()->cost;
        }

        $profile_summ = 0;
        if(Auth::user()->is_admin) {
            $profiles = Profile::where('is_published', '1')->get();
        } else {
            $profiles = Profile::where('is_published', '1')->where('user_id', Auth::user()->id)->get();
        }
        
        foreach($profiles as $profile) {
           $profile_summ = $profile_summ  +  $profile->rates()->first()->cost;
        }

        $salon = Auth::user()->salons();
        return view('user.payments.index', [
            'profiles' => Auth::user()->profiles,
            'hairs' => $this->hairs,
            'rates' => $this->rates,
            'rates' => $this->rates,
            'bonuses' => $this->bonuses,
            'salon_summ' => $salon_summ,
            'profile_summ' => $profile_summ,
            'statistics' => Statistic::where('user_id', Auth::user()->id)->get(),
            'salon' => $salon,
        ]);
    }

    public function plusbonusinfo()
    {

        if (request()->has('payment')) {
            if (request()->payment != null) {
                $bonus = Bonus::where('min_sum', '<', request()->payment)->where('max_sum', '>=', request()->payment)->first();

                if ($bonus != null) {
                    return 'Бонусы при пополнении: +' . round(request()->payment * $bonus->koef / 100) . ' Пойнтов';
                } else {
                    return '';
                }
            }
        }
    }

    public function errorpayment()
    {
        return view('user.payments.error');
    }

    public function successpayment()
    {
        return view('user.payments.success');
    }

    public function makepayment()
    {

        $key = hash('sha256', $_POST['LMI_PAYEE_PURSE'] .
            $_POST['LMI_PAYMENT_AMOUNT'] .
            $_POST['LMI_PAYMENT_NO'] .
            $_POST['LMI_MODE'] .
            $_POST['LMI_SYS_INVS_NO'] .
            $_POST['LMI_SYS_TRANS_NO'] .
            $_POST['LMI_SYS_TRANS_DATE'] .
            '5140237D-B9C2-461B-B590-EC224BBC55AD' .
            $_POST['LMI_PAYER_PURSE'] .
            $_POST['LMI_PAYER_WM']);

        if (strtoupper($key) != $_POST['LMI_HASH']) {
            return redirect(route('user.errorpayment'));
        }

        $current_balance = Auth::user()->user_balance;
        $payment = $_POST('LMI_PAYMENT_AMOUNT');
        $bonus = Bonus::where('min_sum', '<', $payment)->where('max_sum', '>=', $payment)->first();

        if ($bonus != null) {
            $payment = $payment + ($payment * $bonus->koef / 100);
        }

        Auth::user()->user_balance = $current_balance + $payment;
        Auth::user()->save();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = $payment;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        return back()->withSuccess('Успешно пополнен баланс');
    }

    public function promotionalpayment()
    {

        request()->validate([
            'promotionalpayment' => 'required|exists:promotionals,code',
        ]);

        $codes = Promotional::where('code', request()->promotionalpayment)->where('is_activated', false);
        if ($codes->count() > 0) {
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
            return back()->withSuccess('Успешно пополнен баланс');
        } else {
            return back()->withFail('Промокод не найден');
        }

    }

    public function changeServicePrice()
    {

        $profile = Profile::find(request()->profile_id);
        $service = Service::find(request()->service_id);

        if ($profile->user_id == Auth::user()->id) {

            $profile->services()->detach($service);
            $profile->services()->attach(
                $service, ['price' => request()->price]
            );

        }
    }

    public function changephone()
    {
        $profile = Profile::find(request()->profile_id);
        $profile->phone = request()->phone;
        $profile->update();
    }

    public function changerate()
    {
        $profile = Profile::find(request()->profile_id);

        if($profile->rates()->count() > 0){
            $profile->rates()->detach();
        }
        
        $profile->rates()->attach(Rate::findOrFail(request()->rate_id));
        $profile->update();
    }

    

    public function detachService()
    {
        $profile = Profile::find(request()->profile_id);
        $service = Service::find(request()->service_id);

        if ($profile->user_id == Auth::user()->id) {

            $profile->services()->detach($service);

        }
    }

    public function attachService()
    {
        $profile = Profile::find(request()->profile_id);
        $service = Service::find(request()->service_id);

        if ($profile->user_id == Auth::user()->id) {

            $profile->services()->attach(
                $service, ['price' => request()->price]
            );

        }  
    }

    public function deleteimagesattach()
    {
        $image = Image::where('id', request()->image_id)->where('profile_id', request()->profile_id);
        $image->delete();
        return;
    }
}
