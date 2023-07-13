<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Ип
 * Class Ip
 */
class Ip extends Model
{
    use HasFactory;
    use Crud;
    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'name', 'ip', 'active'
    ];


}
