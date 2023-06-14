<?php


namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menusData = [
            [
                'data' =>
                    [
                        'name' => 'Главная',
                        'url' => '/',
                        'actual' => true,
                        'icon' => null,
                        'sort' => 1,
                        'menu_id' => null
                    ],
                'roles_slug' => ['F']//массив ролей
            ],
            [
                'data' =>
                    [
                        'name' => 'Админ',
                        'url' => 'admin',
                        'actual' => true,
                        'icon' => null,
                        'sort' => 2,
                        'menu_id' => null
                    ],
                'roles_slug' => ['А']//массив ролей
            ]
        ];

        foreach ($menusData as $item) {
            $menu = Menu::whereUrl($item['data']['url'])->first();
            if($menu){
                $menu->edit($item['data']);
            }else{
                $menu = Menu::add($item['data']);
            }
            if (isset($item['roles_slug'])) {
                $role = Role::whereIn('slug', $item['roles_slug'])->get();
                $menu->roles()->sync($role);
                $menu->save();
            }
        }
    }
}
