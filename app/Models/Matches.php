<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Matches extends Model
{
    use HasFactory;
    use Crud;
    use HasSlug;

    protected $fillable = [
        'event_id',
        'slug',
        'date_event',
        'name',
        'name_ru',
        'description',
        'team_home_id',
        'team_away_id',
        'bet',
        'odds',
        'all_tips',
        'win_tips',
        'league_id',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public static function doAdd(array $data): int
    {
        $matches = self::where('date_event', '=', $data['date_event'])->where(['team_home_id' => $data['team_home_id'], 'team_away_id' => $data['team_away_id']])->first();
        $result = [
            'event_id' => $data['event_id'],
            'date_event' => $data['date_event'],
            'name' => $data['matches'],
            'description' => isset($data['description']) ? $data['description'] : null,
            'team_home_id' => $data['team_home_id'],
            'team_away_id' => $data['team_away_id'],
            'league_id' => isset($data['league_id']) ? $data['league_id'] : null,
        ];
        if(!$matches){
            $matches = self::add($result);
        }
        return $matches->id;
    }

    public function forecasts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Forecasts::class, 'matche_id', 'id');
    }

    public function events (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Events::class, 'event_id', 'id');
    }

    /**
     * Домашняя команда
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamHome (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_home_id', 'id');
    }

    /**
     * Команда гостей
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamsAway (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teams::class, 'team_away_id', 'id');
    }

    public function league (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Leagues::class, 'league_id', 'id');
    }

    public function result(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Results::class, 'matche_id');
    }

    public static function getActualMach() : collection
    {
        $currentTime = Carbon::now()->setTimezone(config('app.timezone'));
        return self::where('date_event', '>=', $currentTime)->get();

    }
}
