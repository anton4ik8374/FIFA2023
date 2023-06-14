<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Меню
 * Class Menu
 */
class Menu extends Model
{
    use HasFactory;

    /**
     * Дефолтное значение
     */
    public const DEFAULT = 0;

    /**
     * Значение присваивается по умолчанию
     * @var int[]
     */
    protected $attributes = [
        'actual' => self::DEFAULT
    ];

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'url',
        'actual',
        'icon',
        'sort',
        'menu_id'
    ];

    /**
     * Связь к Модели Роли
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'menus_roles');
    }

    /**
     * Создаём новую запись
     * @param $filds
     * @return static
     */
    public static function add($filds): static
    {
        $menu = new static;
        $menu->fill($filds);
        $menu->save();

        return $menu;
    }

    /**
     * Редактирование записи
     * @param $fields
     * @return bool
     */
    public function edit($fields): bool
    {
        $this->fill($fields);
        return $this->save();
    }

    /**
     * Получение общего меню
     * @param string $slug
     * @return mixed
     */
    public static function getMenu(string $slug): mixed
    {
        $menus = Role::where('slug', $slug)->first()->menus();
        return $menus->where('actual', true)->orderBy('sort', 'ASC')->get()->toArray();
    }

    /**
     * Удаляем запись
     * @return void
     */
    public function remove(): void
    {
        $this->delete();
    }

    /**
     * Строим зависимость пунктов меню
     * @param $menus
     * @return mixed
     */
    public static function buildTree($menus): mixed
    {
        $grouped = $menus->groupBy('menu_id');

        foreach ($menus as $menu) {
            if ($grouped->has($menu->id)) {
                $menu->children = $grouped[$menu->id];
            }
        }
        return $menus->whereNull('menu_id');
    }

    /**
     * Мутатор для поля created_at возвращает преобразованную дату
     * @return mixed
     */
    public function getFormatDateCreate(): mixed
    {
        return $this->created_at->format('d F Y H:i');
    }

    /**
     * Мутатор для поля updated_at возвращает преобразованную дату
     * @return mixed
     */
    public function getFormatDateUpdate(): mixed
    {
        return $this->updated_at->format('d F Y H:i');
    }
}
