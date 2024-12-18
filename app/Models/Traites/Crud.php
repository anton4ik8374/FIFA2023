<?php

namespace App\Models\Traites;

trait Crud
{
    /**
     * Создаём новую запись
     * @param $filds
     * @return static
     */
    public static function add($filds): static
    {
        $item = new static;
        $item->fill($filds);
        $item->save();

        return $item;
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
     * Удаляем запись
     * @return void
     */
    public function remove(): void
    {
        $this->delete();
    }
}
