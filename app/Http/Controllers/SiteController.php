<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function __construct()
    {

        $this->services = Service::with('childrenRecursive')->whereNull('parent_id')->get();
        $this->appearances = Appearance::all();
        $this->profiles = Profile::all();

    }

    public function index(Request $request) {

        $services = Service::all();
        $hairs = Hair::all();
        $appearances = Appearance::all();

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

        $profiles = Profile::where('is_published', 1)->where('is_archived', 0)->take(18)->get();

        return view('sitepath.index')->with([
            'profiles' => $profiles,
            'services' => $services,
            'service_iterator' => 0,
        ]);
    }

    public function map() {
        return view('sitepath.map');
    }

    public function salons() {
        return view('sitepath.salons');
    }

    public function profile() {
        return view('sitepath.profile');
    }

}
