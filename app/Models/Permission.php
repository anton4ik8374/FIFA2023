<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Разрешение
 * Class Permission
 */
class Permission extends Model
{
    use HasFactory;
    use Crud;

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    /**
     * Связь к Модели Роли один к обному
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }


}
