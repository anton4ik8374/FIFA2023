<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель Ип
 * Class Ip
 */
class Ip extends Model
{

    /**
     * Атрибуты, которые можно массово присваивать.
     * @var string[]
     */
    protected $fillable = [
        'name', 'ip', 'active'
    ];

    /**
     * Создаём новую запись
     * @param $filds
     * @return static
     */
    public static function add($filds): static
    {
        $ip = new static;
        $ip->fill($filds);
        $ip->save();

        return $ip;
    }

    /**
     * Редактирование записи
     * @param $filds
     * @return $this
     */
    public function edit($filds): static
    {
        $filds['active'] = isset($filds['active']) ? 1 : 0;
        $this->fill($filds);
        $this->save($filds);
        return $this;
    }

}
