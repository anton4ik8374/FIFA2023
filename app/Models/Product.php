<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Название таблицы
     * @var string
     */
    protected $table = 'products';

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'name','price','sum','count','description','cheque_id','type_id','is_credit'
    ];

    /**
     * Связь к Модели Тип товара один к одному
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'type_id', 'id');
    }

    /**
     * Связь к Модели Чек один к одному
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cheque (): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cheque::class, 'cheque_id', 'id');
    }

    /**
     * Создаём новую запись
     * @param $fields
     * @return static
     */
    public static function add($fields): static
    {
        $procedure = new static;
        $procedure->fill($fields);
        $procedure->save();

        return $procedure;
    }

    /**
     * Редактирование записи
     * @param $filds
     * @return bool
     */
    public function edit($filds): bool
    {
        $this->fill($filds);
        return $this->save();

    }
}
