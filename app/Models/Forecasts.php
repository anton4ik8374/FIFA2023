<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecasts extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'id',
        'author',
        'roi',
        'odds',
        'header',
        'forecast',
        'like',
        'dislike',
        'date_publish',
        'team_home_id',
        'team_away_id',
        'selection_id',
    ];
}
