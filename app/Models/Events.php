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


    /**
     * Возвращаем записи которые не обработаны
     * @return mixed
     */
    public static function getUnprocessed(){
        return self::whereStatus(false)->get();
    }
}
