<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Leagues extends Model
{
    use HasFactory;
    use Crud;
    use HasSlug;

    protected $fillable = [
        'id',
        'slug',
        'name',
        'name_en'
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
        $league = self::where('name', '=', $data['league'])->first();
        $newData = [
            'name' => $data['league'],
        ];
        if(!$league){
            $league = self::add($newData);
        }
        return $league->id;
    }
}
