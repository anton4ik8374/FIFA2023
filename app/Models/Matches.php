<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'id',
        'event_id',
        'date_event',
        'name',
        'description',
        'team_home_id',
        'team_away_id',
        'selection_id',
        'odds',
        'all_tips',
        'win_tips',
        'league',
    ];
}
