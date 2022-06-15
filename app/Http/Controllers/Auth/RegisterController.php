<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Gender;
use App\Models\FamilyType;
use App\Models\Occupation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'     => ['required', 'string', 'max:20'],
            'last_name'      => ['required', 'string', 'max:20'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function showRegistrationForm()
    {
        $occupations      = Occupation::all();
        $genders          = Gender::all();
        $family_types     = FamilyType::all();
        return view('auth.register',compact('occupations','genders','family_types'));
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $preferences = ['occupations','family_types','annual_income_range','manglik_preference'];
        foreach($preferences as $preference) {
            $data[$preference] = $request->all()[$preference];
            unset($request->all()[$preference]);
        }

        $user = $this->create($request->all());
        $user->createPartnerPreference($data);

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect('/login')->with('success','Registration Success!, Login to continue...');
    }
    protected function create(array $data)
    { 
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }
}
