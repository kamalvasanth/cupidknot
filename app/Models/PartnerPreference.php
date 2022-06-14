<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPreference extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function occupations() {
        return $this->morphedByMany(Occupation::class, 'preferable');
    }
    public function family_types() {
        return $this->morphedByMany(FamilyType::class, 'preferable');
    }
}
