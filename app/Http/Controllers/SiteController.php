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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class SiteController extends Controller
{

    public $services;
    public $appearances;
    public $profiles;
    public $rates;

    public function __construct()
    {

        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->profiles = Profile::all();
        $this->rates = Rate::all();

    }

    public function index(Request $request) {

        $services = Service::all();
        $hairs = Hair::all();
        $appearances = Appearance::all();
        $districts = District::all();

        $age_min = Profile::min('age');
        $age_max = Profile::max('age');

        $boobs_min = Profile::min('boobs');
        $boobs_max = Profile::max('boobs');

        $weight_min = Profile::min('weight');
        $weight_max = Profile::max('weight');

        $height_min = Profile::min('height');
        $height_max = Profile::max('height');

        $one_hour_min = Profile::min('one_hour');
        $one_hour_max = Profile::max('one_hour');

        $two_hour_min = Profile::min('two_hour');
        $two_hour_max = Profile::max('two_hour');

        $all_night_min = Profile::min('all_night');
        $all_night_max = Profile::max('all_night');

        $profiles = Profile::where('is_published', '1')->where('allowed', '1')->where('is_archived', '0')->take(18)->get();

        foreach ($profiles as $profile) {
            $profile['phone'] = $this->formatPhone($profile['phone']); 
        }

        $collection = collect(['boobs_min', 'boobs_max', 'age_min', 'age_max', 'weight_min', 'weight_max', 'height_min', 'height_max',
            'one_hour_min', 'one_hour_max', 'two_hour_min', 'two_hour_max', 'all_night_min', 'all_night_max']);

        $filtersDefaultCollection = $collection->combine([$boobs_min, $boobs_max, $age_min, $age_max, $weight_min, $weight_max, $height_min, $height_max,
            $one_hour_min, $one_hour_max, $two_hour_min, $two_hour_max, $all_night_min, $all_night_max]);

        return view('sitepath.index')->with([
            'profiles' => $profiles,
            'services' => $services,
            'hairs' => $hairs,
            'appearances' => $appearances,
            'districts' => $districts,
            'rates' => $this->rates,

            'filtersDefaultCollection' => $filtersDefaultCollection,

        ]);
    }

    public function archived(Request $request) {

        $profiles = Profile::where('is_published', '1')->where('allowed', '1')->where('is_archived', '1')->take(18)->get();

        foreach ($profiles as $profile) {
            $profile['phone'] = $this->formatPhone($profile['phone']); 
        }

        return view('sitepath.archived')->with([
            'profiles' => $profiles,
        ]);
    }

    function load_data(Request $request)
    {

        if($request->ajax())
        {
            $output = '<div class="row">';
            $last_id = '';

            if($request->ids == null || !is_array($request->ids)) {
                $ids = [0];
            } else {
                $ids = $request->ids;
            }

            if(!$request->has('archived')){
                

                $data = Rate::OrderBy('cost', 'desc')->with(['profiles' => function($query) use ($ids, $request) {
                    $query->where('is_archived', 0)->where('is_published', 1)->where('allowed', '1')->whereNotIn('profile_id', $ids);

                    if($request->has('one_hour_min') && $request->one_hour_min != null ){
                        $query->where('one_hour', '>=' ,$request->one_hour_min);
                    };
        
                    if($request->has('one_hour_max') && $request->one_hour_max != null ){
                        $query->where('one_hour', '<=' ,$request->one_hour_max);
                    };
        
                    if($request->has('two_hour_min') && $request->two_hour_min != null ){
                        $query->where('two_hour', '>=' ,$request->two_hour_min);
                    };
        
                    if($request->has('two_hour_max') && $request->two_hour_max != null ){
                        $query->where('two_hour', '<=' ,$request->two_hour_max);
                    };
        
                    if($request->has('all_night_min') && $request->all_night_min != null ){
                        $query->where('all_night', '>=' ,$request->all_night_min);
                    };
        
                    if($request->has('all_night_max') && $request->all_night_max != null){
                        $query->where('all_night', '<=' ,$request->all_night_max);
                    };
        
                    if($request->has('age_min') && $request->age_min != null){
                        $query->where('age', '>=' ,$request->age_min);
                    };
        
                    if($request->has('age_max') && $request->age_max != null){
                        $query->where('age', '<=' ,$request->age_max);
                    };
        
                    if($request->has('height_min')){
                        $query->where('height', '>=' ,$request->height_min);
                    };
        
                    if($request->has('height_max')){
                        $query->where('height', '<=' ,$request->height_max);
                    };
        
                    if($request->has('boobs_min')){
                        $query->where('boobs', '>=' ,$request->boobs_min);
                    };
        
                    if($request->has('boobs_max')){
                        $query->where('boobs', '<=' ,$request->boobs_max);
                    };
        
                    if($request->has('verified')){
                        $query->where('verified', $request->verified);
                    };
        
                    if($request->has('apartments')){
                        $query->where('apartments', $request->apartments);
                    };
        
                    if($request->has('check_out')){
                        $query->where('check_out', $request->check_out);
                    };
        
                    if($request->has('new_profiles')){
                        $query->where('created_at', '>=', Carbon::now()->subDays(14));
                    };
        
                    if($request->has('services')) {
        
                        $query->whereHas('services', function($query) use($request){
                            $query->whereIn('service_id', $request->services);
                        });
        
                    }
        
                    if($request->has('appearances')) {
        
                        $query->whereHas('appearances', function($query) use($request){
                            $query->whereIn('appearance_id', $request->appearances);
                        });
        
                    }
        
                    if($request->has('hairs')) {
        
                        $query->whereHas('hairs', function($query) use($request){
                            $query->whereIn('hair_id', $request->hairs);
                        });
        
                    }
        
                    if($request->has('districts')) {
        
                        $query->whereHas('districts', function($query) use($request){
                            $query->whereIn('district_id', $request->districts);
                        });
        
                    }
                }])->get();
            } else {
                $data = Rate::OrderBy('cost', 'desc')->with(['profiles' => function($query) use ($ids, $request) {
                    $query->where('is_archived', 1)->where('is_published', 1)->where('allowed', '1')->whereNotIn('profile_id', $ids);
                }])->get();
            }

            

            $arrCollections = array();
            foreach($data as $rate) {
                $shuffled = $rate->profiles->shuffle();
                array_push($arrCollections, $shuffled);
            }

            $collection = collect($arrCollections)->collapse();
            $request_id = (int)$request->get('id');
            if(!is_int($request_id)) {
                $request_id = 0;
            } elseif($collection->count() < $request_id){
                $request_id = 0;
            }

            $data = $collection->slice($request_id)->take(18);
           
           

            if(!$data->isEmpty())
            {
                $iteration = 0;
                foreach($data as $row)
                {
                    $iteration += 1;

                    if($row->verified) {
                        $verified = '<a class="nc-point" href="#"><img src="images/approved.png" alt="Подтверждена"></a>';
                    } else {
                        $verified = '';
                    };

                    if($row->apartments) {
                        $apartments = '<a class="nc-point" href = "#" ><img src = "images/apartments.png" alt = "Апартаменты" ></a >';
                    } else {
                        $apartments = '';
                    };

                    if($row->check_out) {
                        $check_out = '<a class="nc-point" href = "#" ><img src = "images/car.png" alt = "Выезд" ></a >';
                    } else {
                        $check_out = '';
                    };

                    if(!$request->has('archived')) {
                        $phone = '<span><a href="tel:' . $this->formatPhone($row->phone)  . '" style="color:#fff">'. $this->formatPhone($row->phone) . '</a></span>';
                    } else {
                        $phone = '';
                    }

                    if($row->profileWork24Hours || $row->working_hours_from) {
                        $timework = ' /';
                        if($row->profileWork24Hours) {
                            $timework .= ' Всегда';
                        } else {
                            $timework .= ' с ' . $row->working_hours_from . ' до '. $row->working_hours_to;
                        }
                    } else {
                        $timework = '';
                    };


                    if($request->has('archived')) {
                        $output .= '<div class="col-md-3 col-sx-6 nc-col profile_wrapper" profile_id="' . $row->id . '" >
                        <div class="nc-card d-flex flex-column justify-content-between"
                        style = "
                        
                        background: linear-gradient(360deg, rgba(2, 0, 0, 0.5) 0%, rgba(59, 18, 24, 0.5) 18%, rgba(72, 26, 35, 0.5) 33%, rgba(61, 41, 50, 0.5) 54%, rgba(58, 45, 55, 0.5) 100%), url(/images/profiles/images/created/'. $row->main_image .') no-repeat;
                        background-size: cover;
                        "
                        >
                            <div class="nc-card-top">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    '. $verified . $apartments . $check_out .'
                                </div>
                            </div>
                                        <div class="nc-card-bottom">
                                            <h4 class="h4" style="    font-size: 1.1rem;"><a href="' . route("getprofile", $row->id) . '">'.$row->name. '<span>| '.$row->age.' года</span></a> </h4>
                                            <div class="d-flex justify-content-around">
                                                <p class="nc-price"><span>за час</span><br> ' . $row->one_hour .'</p>
                                                <p class="nc-price"><span>за 2 часа</span><br> '.$row->two_hour. '</p>
                                                <p class="nc-price"><span>за ночь</span><br> '.$row->all_night .'</p>
                                            </div>
                                            <div class="nc-location d-flex">
                                                <img class="img-fluid align-self-center" src="images/location.png">
                                                <div class="align-self-center ml-2 d-flex flex-column">
                                                    '. $phone .'
                                                    <span>'.$row->districts->first()->name . $timework . '</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                        if($iteration % 4 == 0) {
                            $output .= '</div><div class="row mt-3">';
                        }
                    } else {
                        $output .= '<div class="col-md-4 col-sx-6 nc-col profile_wrapper" profile_id="' . $row->id . '">
                                    <div class="nc-card d-flex flex-column justify-content-between"
                                    style = "
                                    
                                    background: linear-gradient(360deg, rgba(2, 0, 0, 0.5) 0%, rgba(59, 18, 24, 0.5) 18%, rgba(72, 26, 35, 0.5) 33%, rgba(61, 41, 50, 0.5) 54%, rgba(58, 45, 55, 0.5) 100%), url(/images/profiles/images/created/'. $row->main_image .') no-repeat;
                                    background-size: cover;
                                    "
                                    >
                                        <div class="nc-card-top">
                                            <div class="d-flex flex-column justify-content-between align-items-end">
                                                '. $verified . $apartments . $check_out .'
                                            </div>
                                        </div>
                                        <div class="nc-card-bottom">
                                            <h4 class="h4" style="    font-size: 1.1rem;"><a href="' . route("getprofile", $row->id) . '">'.$row->name. '<span>| '.$row->age.' года</span></a> </h4>
                                            <div class="d-flex justify-content-around">
                                                <p class="nc-price"><span>за час</span><br> ' . $row->one_hour .'</p>
                                                <p class="nc-price"><span>за 2 часа</span><br> '.$row->two_hour. '</p>
                                                <p class="nc-price"><span>за ночь</span><br> '.$row->all_night .'</p>
                                            </div>
                                            <div class="nc-location d-flex">
                                                <img class="img-fluid align-self-center" src="images/location.png">
                                                <div class="align-self-center ml-2 d-flex flex-column">
                                                    '. $phone .'
                                                    <span>'.$row->districts->first()->name . $timework . '</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                        if($iteration % 3 == 0) {
                            $output .= '</div><div class="row mt-3">';
                        }
                    }


                    



                    $last_id = $iteration + $request_id;
                }
                $output .= '</div>';
                $output .= '<div class="row justify-content-center mt-3 mb-3 load_more_button">
                                <div class="col-md-4 col-sm-12 nc-col load_more_button">
                                    <button type="button" data-id="'.$last_id.'" class="btn nc-btn-show-more btn-block load_more_button" id="load_more_button" name="load_more_button">
                                        <img src="images/show-more.png" class="mr-2" alt="">
                                        Показать еще 18
                                        анкет
                                    </button>
                                </div>
                            </div>';
            }
            else
            {
                $output = '<div class="row justify-content-center mt-3 mb-3 load_more_button">
                    <div class="col-md-4 col-sm-12 nc-col load_more_button">
                        <button type="button" class="btn nc-btn-show-more btn-block load_more_button">
                            <img src="images/show-more.png" class="mr-2" alt="">
                            Новых анкет не найдено
                        </button>
                    </div></div>
                ';
            }
            echo $output;
        }
    }

    public function map() {

        $profiles = Profile::where('address_x', '<>', '1')->where('address_y', '<>', '1')->where('allowed', '1')->where('is_published', '1')->where('archived', '0')->get();
        return view('sitepath.map')->with(['profiles' => $profiles]);
    }

    public function salons() {
        $salons = Salon::where('is_published', '1')->where('allowed', '1')->get();
        return view('sitepath.salons')->with(['salons' => $salons]);
    }

    public function profile($id) {

        $profile = Profile::where('id', $id)->where('allowed', '1')->where('is_published', '1')->first();
        $similarProfiles = Profile::where('is_published', '1')->where('allowed', '1')->where('is_archived', '0')->take(18)->get();

        $parentServicesNeeds = $profile->services->pluck('parent_id');
        $parent_services = $this->services->whereIn('id', $parentServicesNeeds)->all();

        return view('sitepath.profile')->with([
            'profile' => $profile,
            'phone' => $this->formatPhone($profile->phone),
            'services' => $parent_services,
            'similarProfiles' => $similarProfiles
        ]);
    }

    public function formatPhone($phone) {
        if(  preg_match( '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
        {
            $phone = $matches[1] . ' (' .$matches[2] . ') ' . $matches[3] . '-' . $matches[4] . '-' . $matches[5];
            return $phone;
        } else {
            return $phone;
        }
    }

}
