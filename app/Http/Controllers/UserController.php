<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Gender;
use App\Models\FamilyType;
use App\Models\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function edit($user_id) {
        $user             = User::find($user_id);
        $occupations      = Occupation::all();
        $genders          = Gender::all();
        $family_types     = FamilyType::all();
        return view('users.edit',compact('user','occupations','genders','family_types'));
    }
    public function update($user_id)
    {
       $user = User::find($user_id);
       $data = request()->validate([
            'first_name'     => ['required', 'string', 'max:20'],
            'password'       => ['required', 'string', 'min:8'],
            'dob'            =>  'required',
            'gender_id'      =>  'required',
            'annual_income'  =>  'required',
            'occupation_id'  =>  'required',
            'family_type_id' =>  'required',
            'manglik'        =>  'required',
            // preference
            'annual_income_range' => "required",
            'occupations'         => "required",
            'family_types'        => "required",
            'manglik_preference'  =>  'required',
        ]);
       $user->update($data);
       if(empty($user->partner_preferences)) {
           $user->createPartnerPreference($data);
        }
        return redirect('/home');
    }
    public function report() {
        $query = request()->all();
        $users = DB::table('users')
        ->leftJoin('genders','users.gender_id','=','genders.id')
        ->leftJoin('occupations','users.occupation_id','=','occupations.id')
        ->leftJoin('family_types','users.family_type_id','=','family_types.id')
        ->select(
            'users.first_name as first_name',
            'users.dob as dob',
            'users.email as email',
            'users.annual_income as annual_income',
            'users.last_name as last_name',
            'genders.name as gender',
            'occupations.name as occupation',
            'family_types.name as family_type',
            'users.manglik as manglik',
        )->where('users.id','!=',Auth::user()->id);

        if(isset($query['gender_id'])){
            $users = $users->where('gender_id',$query['gender_id']);
        }
        if(isset($query['occupation_id'])){
            $users = $users->where('occupation_id',$query['occupation_id']);
        }
        if(isset($query['family_type_id'])){
            $users = $users->where('family_type_id',$query['family_type_id']);
        }
        if(isset($query['manglik'])){
            $users = $users->where('manglik',$query['manglik']);
        }
        if(isset($query['age_range'])){
            $age   = explode("-",$query['age_range']);
            $from_date  = Carbon::today()->subYears(intval($age[1]))->toDateString();
            $to_date  = Carbon::today()->subYears(intval($age[0]))->toDateString();
            $users = $users->where('dob','<=',$to_date)->where('dob','>=',$from_date);
        }
        if(isset($query['annual_income_range'])){
            $annual_income  = explode(" - ",$query['annual_income_range']);
            $users = $users->where('annual_income','>=',intval($annual_income[0]))->where('annual_income','<=',intval($annual_income[1]));
        }
        $occupations  = Occupation::all();
        $family_types = FamilyType::all();
        $genders      = Gender::all();
        $users        = $users->get();
        return view('users.report',compact('users','occupations','family_types','genders','query'));
        
    }
}
