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
     * Удаляем запись
     * @return void
     */
    public function remove(): void
    {
        $this->delete();
    }
}
