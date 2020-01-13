<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Promotional;
use App\User;
use App\Service;
use App\Appearance;
use App\Hair;
use App\Image;
use Auth;
use File;
use Transliterate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public $services;
    public $appearances;
    public $hairs;

    public function __construct()
    {
        $this->middleware('auth');
        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->hairs = Hair::all();
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
        return view('admin.profiles.index', ['users' => User::all()]);
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

        $profile = Profile::create($this->validateProfile(true));

        if(request()->has('services')) {
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if(request()->has('appearance')) {
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->has('hair')) {
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if(request()->has('item_images')) {

            $array = explode(",", request()->item_images);
            foreach ($array as $arr ) {
                $image = new Image;
                $image->name = $arr;
                $image->profile_id = $profile->id;
                $image->save();
                File::move(public_path() . '/images/profiles/images/new_upload/' . $image->name, public_path() . '/images/profiles/images/created/' . $image->name);
            }

        }

        return redirect(route('user.profiles.index'));

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

        $profile->update($this->validateProfile(false));

        if(request()->has('services')) {
            $profile->services()->detach();
            foreach (request('services') as $service) {
                $profile->services()->attach(Service::findOrFail($service));
            }
        }

        if(request()->has('appearance')) {
            $profile->appearances()->detach();
            $profile->appearances()->attach(Appearance::findOrFail(request()->appearance));
        }

        if(request()->has('hair')) {
            $profile->hairs()->detach();
            $profile->hairs()->attach(Hair::findOrFail(request()->hair));
        }

        if(request()->has('item_images')) {

            $array = explode(",", request()->item_images);
            foreach ($array as $arr ) {
                $image = new Image;
                $image->name = $arr;
                $image->profile_id = $profile->id;
                $image->save();
                File::move(public_path() . '/images/profiles/images/new_upload/' . $image->name, public_path() . '/images/profiles/images/created/' . $image->name);
            }

        }

        return redirect(route('user.profiles.index'));
    }

    public function publish(Request $request, $id) {
        $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $profile['is_published'] = 1;
        $profile->update();
        return redirect(route('user.profiles.index'));
    }

    public function unpublish(Request $request, $id) {
        $profile = Profile::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $profile['is_published'] = 0;
        $profile->update(); 
        return redirect(route('user.profiles.index'));
    }

    public function verify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 1;
        $profile->update();
        return redirect(route('admin.adminprofiles'));
    }

    public function unverify(Request $request, $id) {
        $profile = Profile::where('id', $id)->firstOrFail();
        $profile['verified'] = 0;
        $profile->update(); 
        return redirect(route('admin.adminprofiles'));
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

        if ($isNew) {
            $this->newValidate();
        } else {
            $this->oldValidate();
        }

        $profileArr = request()->all();
        if (Auth::user()->is_admin && !$isNew) {
        } else {
            $profileArr['user_id'] = Auth::user()->id;
        }

        return $profileArr;
    }

    protected function newValidate()
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|unique:App\Profile,phone|regex:/^((8)+([0-9]){10})$/i',
            'about' => 'required',
            'address' => 'required',
            'address_x' => 'required',
            'address_y' => 'required',
            'working_hours' => 'required',
            'boobs' => 'required|integer|between:1,10',
            'age' => 'required|integer|between:18,65',
            'weight' => 'required|integer|between:40,100',
            'height' => 'required|integer|between:150,195',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
        ]);
    }

    protected function oldValidate()
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required|regex:/^((8)+([0-9]){10})$/i',
            'about' => 'required',
            'address' => 'required',
            'address_x' => 'required',
            'address_y' => 'required',
            'working_hours' => 'required',
            'boobs' => 'required|integer|between:1,10',
            'age' => 'required|integer|between:18,65',
            'weight' => 'required|integer|between:40,100',
            'height' => 'required|integer|between:150,195',
            'one_hour' => 'required|integer|between:1000,50000',
            'two_hour' => 'required|integer|between:1000,100000',
            'all_night' => 'required|integer|between:1000,1000000',
        ]);
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
        return view('user.payments.index');
    }

    public function makepayment() {
        $current_balance = Auth::user()->user_balance;
        Auth::user()->user_balance = $current_balance + request()->payment;
        Auth::user()->save();
        return view('user.payments.index');
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
        }

        return view('user.payments.index');
    }
}
