<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Тип процедуры
 * Class ProductType
 * @package App\Models
 */
class ProductType extends Model
{
    use HasFactory;

    /**
     * Название таблицы
     * @var string
     */
    protected $table = 'products_types';

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'actual'
    ];

    /**
     * Возможные статусы процедуры
     */
    public static int $typeMeal = 1;//Еда
    public static int $typeChemistry = 2;//Химия
    public static int $typeCat = 3;//Животные
    public static int $typeSoft = 4;//Софт
    public static int $typeClothes = 5;//Одежда
    public static int $typeRest = 6;//Отдых
    public static int $typeHabits = 7;//Привычки
    public static int $typeHouse = 8;//Дом
    public static int $typeCredits = 9;//Кредиты
    public static int $typeMedical = 10;//Медицина
    public static int $typeCar = 12;//Машина
    public static int $typeOther = 11;//Остальное
    public static int $typeChildren = 13;//Дети


    /**
     * Создаём новую запись
     * @param $fields
     * @return static
     */
    public static function add($fields): static
    {
        $type = new static;
        $type->fill($fields);
        $type->save();

        return $type;
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
     * Связь с таблицей Товары
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function procedure (): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Product::class, 'type_id');
    }

    /**
     * Метод преобразования для поля created_at при отдаче
     * @return mixed
     */
    public function getFormatDateCreate(): mixed
    {
        return $this->created_at->format('d F Y H:i');
    }

    /**
     * Метод преобразования для поля updated_at при отдаче
     * @return mixed
     */
    public function getFormatDateUpdate(): mixed
    {
        return $this->updated_at->format('d F Y H:i');
    }

    /**
     * Возвращает id записи по символьному коду
     * @param $code
     * @return int|null
     */
    public static function getIdByCode($code): int|null
    {
        $type = self::whereCode($code)->first();
        if((bool)$type){
            return $type?->id;
        }
        return null;
    }
}
