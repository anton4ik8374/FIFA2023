<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traites\Crud;

class Events extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'id',
        'external_id',
        'name',
        'status',
    ];

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Matches::class, 'event_id', 'id');
    }

    /**
     * Возвращаем записи которые не обработаны
     * @return mixed
     */
    public static function getUnprocessed($name = false){
        if($name){
            return self::whereStatus(false)->whereName($name)->get();
        }
        return self::whereStatus(false)->get();
    }
}
