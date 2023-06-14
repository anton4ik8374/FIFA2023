<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    protected $data = [
        [
            'name' => 'Entrance',
            'description' => 'Разрешен вход в административный раздел',
            'slug' => 'E'
        ],
        [
            'name' => 'Delete',
            'description' => 'Разрешено удалять',
            'slug' => 'D'
        ],
        [
            'name' => 'Access_User',
            'description' => 'Право на создание, удаление, редактирование пользователей',
            'slug' => 'U-CUD'
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $premissi) {
            $permission = Permission::updateOrCreate($premissi);
        }
    }
}
