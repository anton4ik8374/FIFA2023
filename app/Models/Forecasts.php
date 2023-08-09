<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Template\Template;

class Forecasts extends Model
{
    /**
     * one_x_two - (Победитель матча): Сюда входят ставки типа "w1" (победа московского "Динамо") и "w2" (победа Краснодара).
     * both_to_score - (Обе команды забьют): Сюда входит ставка "да", указывающая на то, что ожидается, что обе команды забьют в матче.
     * total_over - (Общее количество голов больше/меньше): Сюда входят ставки типа "2_5", указывающие на то, что общее количество голов, забитых в матче, как ожидается, превысит 2,5.
     * double_chance - Сюда входят ставки типа "х2", указывающие на то, что ожидается победа "Краснодара" в матче или ничья.
     * corners_total_over - (Общее количество поданных угловых больше/меньше): Сюда входят ставки типа "10_5", указывающие на то, что общее количество поданных угловых в матче, как ожидается, превысит 10,5.
     * handicap1 - (Ставки на гандикап): Сюда входит ставка "0", предполагающая, что московское "Динамо", как ожидается, преодолеет гандикап.
     * yellow_cards_total_overv - (Общее количество желтых карточек больше/меньше): Сюда входят ставки типа "5_5", указывающие на то, что ожидается, что общее количество желтых карточек, показанных в матче, превысит 5,5.
     * total_t1_under - (Общее количество голов команды 1 больше/меньше): Сюда входят ставки типа "1_5", указывающие на то, что общее количество голов, забитых командой 1 (Динамо Москва), как ожидается, будет меньше 1,5.
     * total_t2_over - (Общее количество голов команды на 2 больше/меньше): Сюда входят ставки типа "1_5", указывающие на то, что общее количество голов, забитых командой 2 (Краснодар), как ожидается, превысит 1,
     * corners_total_t1_over - (Общее количество поданных угловых для команды 1 Больше/меньше): Сюда входят ставки типа "5_5", указывающие на то, что общее количество поданных угловых командой 1 (Динамо Москва), как ожидается, превысит 5,5.
     * yellow_cards_total_t2_under - (Общее количество желтых карточек у команды 2 Больше/меньше): Сюда входят ставки типа "2_5", указывающие на то, что общее количество желтых карточек, показанных команде 2 (Краснодар), как ожидается, будет меньше 2,5.
     */
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
        'all_tips',
        'win_tips',
        'confidence',
        'outcome',
        'type',
    ];

    public function matches (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Matches::class, 'matche_id', 'id');
    }

    public function teamHome (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_home_id', 'id');
    }
    public function teamAway (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_away_id', 'id');
    }

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
