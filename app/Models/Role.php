<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

/**
 * Модель Роли
 * Class Role
 */
class Role extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    /**
     * Символьное обозначение ролей
     */
    public const SLUG_ADMIN = 'A';
    public const SLUG_ADMIN_BC = 'ABC';
    public const SLUG_MANAGER = 'M';
    public const SLUG_USER = 'U';
    public const SLUG_FREE = 'F';

    /**
     * Связь с таблицей Разрешения
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    /**
     * Связь с таблицей Меню
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Menu::class,'menus_roles');
    }


    /**
     * Создаём новую запись
     * @param $filds
     * @return static
     */
    public static function add($filds): static
    {
        $role = new static;
        $role->fill($filds);
        $role->save();

        return $role;
    }

    /**
     * @param $filds
     * @return $this
     */
    public function edit($filds): static
    {
        $this->fill($filds);
        $this->save($filds);
        return $this;
    }

    /**
     * Возвращаем преобразованную дату создания записи
     * @return mixed
     */
    public function getFormatDateCreate()
    {
        return $this->created_at->format('d F Y H:i');
    }

    /**
     * Возвращаем преобразованную дату последнего обновления записи
     * @return mixed
     */
    public function getFormatDateUpdate()
    {
        return $this->updated_at->format('d F Y H:i');
    }
}
