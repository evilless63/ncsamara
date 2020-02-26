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
use App\Salon;
use Auth;
use File;
use Config;
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
            'bonuses' => $this->bonuses
            ]);
    }

    public function adminindex()
    {
        return view('admin.profiles.index', [
            'users' => User::all(),
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

        return view('user.profiles.create', [
            'services' => $this->services,
            'appearances' => $this->appearances,
            'hairs' => $this->hairs,
            'districts' => $this->districts,
            'bonuses' => $this->bonuses
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
                'phone' => 'required|unique:App\Profile,phone|regex:/^((8)+([0-9]){10})$/i',
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
        
        $errString = "Не заполнены, или заполнены не правильно поля:";
        if ($validator->fails()) {
            
            foreach($validator->errors()->all() as $error => $val) {
                $errString = $errString . ", \n" . $val;
            }
            
           
            return redirect(route('user.profiles.create'))
                        ->withErrors($errString)
                        ->withInput();
        }
        
       

        $profileArr = request()->all()->toArray();

        if(Auth::user()->is_admin) {
            $profileArr = Arr::add($profileArr, 'is_archived', 0);
            $profileArr = Arr::add($profileArr, 'allowed', 1);
            $profileArr = Arr::add($profileArr, 'on_moderate', 0);
        } else {
            $profileArr = Arr::add($profileArr, 'on_moderate', 1);
            $profileArr = Arr::add($profileArr, 'allowed', 0);
            $profileArr = Arr::add($profileArr, 'is_archived', 1);
        }

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
                $image->name = str_replace('"', '', $arr);
                $image->profile_id = $profile->id;
                $image->save();
                //File::move(public_path() . '/images/profiles/images/new_upload' . $image->name .'', public_path() . '/images/profiles/images/created' . $image->name .'');
            }

        }

        if(request()->has('main_image')) {
            // $_IMAGE = $request->file('main_image');
            // $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());

            // $uploadPath = public_path() . '/images/profiles/main/created';
            // $_IMAGE->move($uploadPath,$filename);

            $profile['main_image'] = str_replace('"', '', request()->main_image);
            // $profile->update();
        }

        $profile->rates()->attach(Rate::first());

        // return redirect(route('user.profiles.index'))->withSuccess('Успешно создано');
        return redirect(route('user.profiles.edit', $profile->id))->withSuccess('Успешно создано. Нажмите "Услуги" чтобы перейти к выбору услуг');

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
            'bonuses' => $this->bonuses
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
                'phone' => 'required|regex:/^((8)+([0-9]){10})$/i',
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
        
        $errString = "Не заполнены, или заполнены не правильно поля:";
        if ($validator->fails()) {
            
            foreach($validator->errors()->all() as $error => $val) {
                $errString = $errString . ", \n" . $val;
            }
            
           
            return redirect(route('user.profiles.edit', $profile->id))
                        ->withErrors($errString)
                        ->withInput();
        }

        $profileArr = request()->all()->toArray();

        if (Auth::user()->is_admin) {
        } else {
            $profileArr['user_id'] = Auth::user()->id;
            $profileArr = Arr::add($profileArr, 'on_moderate', 1);
            $profileArr = Arr::add($profileArr, 'allowed', 0);
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
                $image->name = str_replace('"', '', $arr);
                $image->profile_id = $profile->id;
                $image->save();
                //File::move(public_path() . '/images/profiles/images/new_upload/' . $image->name .'', public_path() . '/images/profiles/images/created/' . $image->name .'');
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

        // $_IMAGE = $request->has('main_image');

        if($request->has('main_image')) {
            // $filename = $this->regexpImages(time().$_IMAGE->getClientOriginalName());
            // $uploadPath = public_path() . '/images/profiles/main/created';
            // File::delete(public_path() . '/images/profiles/main/created' . $profile->main_image );
            // $_IMAGE->move($uploadPath,$filename);

            $profile['main_image'] = str_replace('"', '', request()->main_image);
           
            $profile->update();
        }
      

        // if(Auth::user()->is_admin) {
        //     return redirect(route('admin.adminprofiles'))->withSuccess('Успешно обновлено');
        // } else {
        //     return redirect(route('user.profiles.index'))->withSuccess('Успешно обновлено');
        // }

        return back()->withSuccess('Успешно обновлено');

    }

    public function publish(Request $request, $id) {

        if(auth()->user()->is_admin) {
            $profile = Profile::where('id', $id)->firstOrFail();

            $profile['is_published'] = 1;
            $profile['is_archived'] = 0;
            $profile->update();
        
            return back()->withSuccess('Успешно опубликована');
            
        } else {
            $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
            activate($request, $id);

            if(!$profile->is_archived) {
                return back()->withSuccess('Успешно оплачена и опубликована');
            } else {
                return back()->withSuccess('Недостаточно средств на балансе !');
            }
        }
 
    }

    public function unpublish($id, $is_cron = false) {

        $profile = Profile::where('id', $id)->firstOrFail();
        if(auth()->user()->is_admin) {
            
            $profile['is_published'] = 0;
            $profile['is_archived'] = 1;
            $profile->update();
            
        } else {
            
            if(!$profile->is_arhived) {

                if(!$is_cron) {
                    $user = $profile->user; 
                    $rate = $profile->rates->first();
                    $hour = Carbon::now()->timezone(Config::get('app.timezone'))->format('H');
                    $cost = ($rate->cost / 24 * (24 - $hour));
                    $user['user_balance'] = $user->user_balance + $cost;
                    $user->update();
                }

                $profile['is_archived'] = true;
                $profile['is_published'] = false;
            
                return back()->withSuccess('Успешно снята с публикации');
            }
        }

        $profile = Profile::where('id', $id)->firstOrFail();
        // } else {
        //     $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        // }
       

        $profile->update();

    }

    public function verify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 1;
        $profile->update();
        return back()->withSuccess('Успешно подтверждена');
    }

    public function unverify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 0;
        $profile->update();
        return back()->withSuccess('Успешно снята с подтверждения');
    }

    public function moderateallow(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['allowed'] = 1;
        $profile->update();
        return back()->withSuccess('Успешно запрещена к публикации');
    }

    public function moderatedisallow(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['allowed'] = 0;
        $profile->update();
        return back()->withSuccess('Успешно запрещена к публикации');
    }

    public function userbanoff(Request $request, $id) {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 0;
        $user->update();
        return back()->withSuccess('Успешно забанен');
    }

    public function userbanon(Request $request, $id) {
        $user = User::where('id', $id)->firstOrFail();
        $user['is_banned'] = 1;
        $user->update();
        return back()->withSuccess('Успешно разбанен');
    }

    //Для крона
    public function activateCron() {
        $profiles = Profile::where('is_published')->get();

        foreach($profiles as $profile) {
           $this->activate($profile->id, true);       
        }
    }

    public function activate(Request $request = null, $id, $is_cron = false) {

        $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = $profile->user;

        if($user->is_admin) {
            return;
        }

        $rate = $profile->rates->first();
        $hour = Carbon::now()->timezone(Config::get('app.timezone'))->format('H');

        if($is_cron) {
            $cost = $rate->cost;
        } else {
            $cost = ($rate->cost / 24 * (24 - $hour));
        }

        if(($user->user_balance - $cost) < 0) {
           $this->unpublish($id, $is_cron); 
           return
        }

        $user['user_balance'] = $user->user_balance - $cost;
        $user->update();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = $cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $profile['is_archived'] = false;
        $profile['is_published'] = true;
        $profile['last_payment'] = Carbon::now();
        $profile['next_payment'] = Carbon::now()->addDays(1);

        $next_payment = Carbon::parse($profile->next_payment);
        $last_payment = Carbon::parse($profile->last_payment);
        $profile['minutes_to_archive'] = $next_payment->diffInMinutes($last_payment);

        $profile->update();

    }

    public function activatesalon(Request $request, $id) {
   
        $salon = Salon::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = $salon->user;
        $rate = $salon->rates->first();

        if(($user->user_balance - $rate->cost) < 0) {
            $salon['is_approved'] = false;
            $salon->update();
            return back()->withFail('Не достаточно денег на балансе');
        }

        $user['user_balance'] = $user->user_balance - $rate->cost;
        $user->update();

        $statistic = new Statistic();
        $statistic['user_id'] = Auth::user()->id;
        $statistic['payment'] = - $rate->cost;
        $statistic['where_was'] = Carbon::now();
        $statistic->save();

        $salon['is_approved'] = true;
        $salon['last_payment'] = Carbon::now();
        $salon['next_payment'] = Carbon::now()->addDays(1);

        $next_payment = Carbon::parse($salon->next_payment);
        $last_payment = Carbon::parse($salon->last_payment);
        $salon['minutes_to_archive'] = $next_payment->diffInMinutes($last_payment);
        $salon->update();

        return back()->withSuccess('Успешно оплачена');

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
             return $this->validate(request(), [
                 'name' => 'required',
                'phone' => 'required|unique:App\Profile,phone|regex:/^((8)+([0-9]){10})$/i',
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
                'phone' => 'required|regex:/^((8)+([0-9]){10})$/i',
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
        $filename = $this->regexpImages(str_replace('"', '', time().$_IMAGE->getClientOriginalName()));
        $uploadPath = 'images/profiles/images/created';
        $_IMAGE->move($uploadPath,str_replace('"', '', $filename));
        echo json_encode($filename);
    }

    public function removeUpload(Request $request)
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
        return preg_replace("/[^A-Za-z\d\.]/", '', Transliterate::make($imageName));
    }

    public function payments() {
        $salon  = Auth::user()->salon();
        return view('user.payments.index', [
            'profiles' => Auth::user()->profiles,
            'hairs' => $this->hairs,
            'rates' => $this->rates,
            'bonuses' => $this->bonuses,
            'salon' => $salon,
        ]);
    }

    public function plusbonusinfo() {

        if(request()->has('payment')) {
            if(request()->payment <> null) {
                $bonus = Bonus::where('min_sum','<',request()->payment)->where('max_sum','>=', request()->payment)->first();

                if($bonus <> null) {
                    return 'Бонусы при пополнении: +' . round(request()->payment * $bonus->koef / 100) . ' Пойнтов';;
                } else {
                    return '';
                }
            }
        }
    }

    public function errorpayment() {
        return view('user.payments.error');
    }

    public function successpayment() {
        return view('user.payments.success');    
    }

    public function makepayment() {

        $key = hash('sha256', $_POST['LMI_PAYEE_PURSE'].
        $_POST['LMI_PAYMENT_AMOUNT'].
        $_POST['LMI_PAYMENT_NO'].
        $_POST['LMI_MODE'].
        $_POST['LMI_SYS_INVS_NO'].
        $_POST['LMI_SYS_TRANS_NO'].
        $_POST['LMI_SYS_TRANS_DATE'].
        '5140237D-B9C2-461B-B590-EC224BBC55AD'.
        $_POST['LMI_PAYER_PURSE'].
        $_POST['LMI_PAYER_WM']);

        if(strtoupper($key) != $_POST['LMI_HASH'])
            return redirect(route('user.errorpayment'));

        $current_balance = Auth::user()->user_balance;
        $payment = $_POST('LMI_PAYMENT_AMOUNT');
        $bonus = Bonus::where('min_sum','<',  $payment)->where('max_sum','>=', $payment)->first();

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

        return back()->withSuccess('Успешно пополнен баланс');
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
            return back()->withSuccess('Успешно пополнен баланс');
        }
        else {
            return back()->withFail('Промокод не найден');
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
    
    public function deleteimagesattach()
    {
        $image = Image::where('id', request()->image_id)->where('profile_id', request()->profile_id);
        $image->delete();
        return;
    }
}
