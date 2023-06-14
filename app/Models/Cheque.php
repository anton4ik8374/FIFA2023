<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Чеки
 * Class Cheque
 * @package App\Models
 */
class Cheque extends Model
{
    use HasFactory;

    /**
     * Название таблицы
     * @var string
     */
    protected $table = 'cheques';

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'query_request',
        'response',
        'response_code',
        'date_cheque',
        'price',
        'is_credit',
    ];

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
     * @param $query
     * @param array $data
     * @return mixed
     */
    public function scopeSearch($query, array $data): mixed
    {
        foreach ($data as $k => $p) {
            $query->where("query_request->{$k}", $p);
        }
        return $query;
    }

    /**
     * Связь с таблицей Товары
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function procedure (): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Product::class, 'cheque_id');
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
}
