<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use App\Models\Search;
use App\Models\FamilyType;
use App\Models\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = User::find(Auth::user()->id);
        if(!$user->is_admin) {
            if(empty($user->partner_preferences)) {
                return redirect()->route('user.edit',['user_id'=>$user->id]);
            }
            $my_matches = Search::myMatches($user);
            $partner_preference =$user->partner_preferences;
            $partner_preference->occupations= collect($user->partner_preferences->occupations)->implode('name', ', ');
            $partner_preference->family_types = collect($user->partner_preferences->family_types)->implode('name', ', ');
            return view('home',compact('user','my_matches','partner_preference'));
        }else {
          return redirect(route('users.report'));
        }
    }
}
