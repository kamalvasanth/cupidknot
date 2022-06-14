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
        $admin_user = User::where('email','admin@cupidknot.com')->get();
        if(!$admin_user) {
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
        User::factory()->count(20)->create();
    }
}
