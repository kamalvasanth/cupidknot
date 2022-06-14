<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name','last_name','email','password','dob','gender_id', 
        'annual_income','occupation_id','family_type_id','manglik','google_id'       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ['gender','occupation','family_type'];

    public function partner_preferences() {
        return $this->hasOne(PartnerPreference::class);
    }

    public function gender() {
        return $this->belongsTo(Gender::class,'gender_id');
    }

    public function occupation() {
        return $this->belongsTo(Occupation::class,'occupation_id');
    }

    public function family_type() {
        return $this->belongsTo(FamilyType::class,'family_type_id');
    }

    public function createPartnerPreference($data) {
        $annual_income = explode("-",$data['annual_income_range']);
        $occupations   = $data['occupations'];
        $family_types  = $data['family_types'];
        $manglik       = $data['manglik_preference'];

       $partner_preference =  $this->partner_preferences()->create([
            'annual_income_minimum' => $annual_income[0],
            'annual_income_maximum' => $annual_income[1],
            'manglik'               => $manglik,
        ]);

        $partner_preference->occupations()->attach($occupations);
        $partner_preference->family_types()->attach($family_types);
    }


    public function calculateMatchScore($prospect_id) {
        $prospect                = User::find($prospect_id);
        $match['occupation']     = in_array($prospect->occupation_id,$this->partner_preferences->occupations->pluck('id')->toArray());
        $match['family_type']    = in_array($prospect->family_type_id,$this->partner_preferences->family_types->pluck('id')->toArray());
        $match['annual_income']  = in_array($prospect->annual_income,
                                   range($this->partner_preferences->annual_income_minimum,$this->partner_preferences->annual_income_maximum));
        $match['manglik']        = $this->partner_preferences->manglik == "Both" ? true : ($this->partner_preferences->manglik == $prospect->manglik);

        $total_fields             = sizeOf($match);
        $number_of_matched_fields = sizeOf(array_filter($match));
        $score                    = intval(($number_of_matched_fields/$total_fields)*100);
        return $score;
    }
}
