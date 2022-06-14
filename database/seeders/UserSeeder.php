<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gender;
use App\Models\FamilyType;
use App\Models\Occupation;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_user = User::where('email','admin@cupidknot.com')->first();
        if(empty($admin_user)) {
            User::create([
                'first_name' =>'Admin',
                'last_name'=>'Cupidknot',
                'email' => 'admin@cupidknot.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'dob' => '1996-10-29',
                'gender_id' => Gender::pluck('id')->random(),
                'annual_income' => 700000,
                'occupation_id'  => Occupation::pluck('id')->random(),
                'family_type_id' => FamilyType::pluck('id')->random(),
                'manglik'     => 'No',
                'is_admin' => 1
            ]);
        }
        $users = User::factory()->count(20)->create();
        $occupation_ids = Occupation::all()->pluck('id')->toArray();
        $family_type_ids = FamilyType::all()->pluck('id')->toArray();
        $users->map(function($user) use($occupation_ids,$family_type_ids){
            $annual_income_minimum = range(100000,1000000);
            $annual_income_min_key    = array_rand(range(100000,1000000));
            $annual_income_maximum = range(1000000,2000000);
            $annual_income_max_key    = array_rand(range(1000000,2000000));
            $user->partner_preferences()->create([
                'annual_income_minimum' => $annual_income_minimum[$annual_income_min_key], 
                'annual_income_maximum' => $annual_income_maximum[$annual_income_max_key], 
                'manglik' => array_rand(['yes','No','Both']), 
            ]);
            shuffle($occupation_ids);
            shuffle($family_type_ids);
            $user->partner_preferences->occupations()->attach([$occupation_ids[0],$occupation_ids[1]]);
            $user->partner_preferences->family_types()->attach([$family_type_ids[0]]);
        });

    }
}
