<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    public static function myMatches(User $user) {
        $results = User::where('gender_id','!=',$user->gender_id)->get();
        $results->map(function($result) use ($user) {
            $result->score = $user->calculateMatchScore($result->id);
        });
        $my_matches = $results->sortByDesc('score');
        return $my_matches;
    }
}
