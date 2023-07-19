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
        'author',
        'matche_id',
        'roi',
        'odds',
        'bet',
        'forecast',
        'like',
        'dislike',
        'date_publish',
        'team_home_id',
        'team_away_id',
        'selection_id',
        'all_tips',
        'win_tips',
        'confidence',
        'outcome',
        'type',
    ];

    public static function doAdd(array $data): int
    {
        $result = [
            'author' => isset($data['author']) ? $data['author'] : null,
            'matche_id' => $data['matche_id'],
            'forecast' => isset($data['forecast']) ? $data['forecast'] : null,
            'bet' => $data['bet'],
            'like' => isset($data['like']) ? $data['like'] : null,
            'dislike' => isset($data['dislike']) ? $data['dislike'] : null,
            'team_home_id' => $data['team_home_id'],
            'type' => isset($data['type']) ? $data['type'] : null,
            'outcome' => isset($data['outcome']) ? $data['outcome'] : null,
            'team_away_id' => $data['team_away_id'],
            'all_tips' => isset($data['all_tips']) ? $data['all_tips'] : null,
            'win_tips' => isset($data['win_tips']) ? $data['win_tips'] : null,
            'confidence' => isset($data['confidence']) ? $data['confidence'] : null,
        ];
        if( isset($data['date_publish'])) {
            $forecasts = self::where('date_publish', '=', $data['date_publish'])->where($result)->first();
        }else{
            $forecasts = self::where($result)->first();
        }
        if(!$forecasts){
            $result['date_publish'] = isset($data['date_publish']) ? $data['date_publish'] : null;
            $result['odds'] = $data['odds'];
            $result['roi'] = isset($data['roi']) ? $data['roi'] : null;
            $forecasts = self::add($result);
        }
        return $forecasts->id;
    }
}
