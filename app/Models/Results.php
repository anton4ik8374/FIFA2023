<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'matche_id',
        'win_team_id',
        'chat_gpt_result',
        'program_analysis_result',
        'count_forecasts',
        'count_forecasts_win'
    ];
}
