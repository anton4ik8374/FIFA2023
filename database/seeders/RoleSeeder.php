<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'data' => [
                    'name' => 'Admin',
                    'description' => 'Администратор',
                    'slug' => 'A',
                ],
                'permission' => ['E', 'D', 'U-CUD']
            ],
            [
                'data' => [
                    'name' => 'User',
                    'description' => 'Пользователь',
                    'slug' => 'U',
                ]
            ],
            [
                'data' => [
                    'name' => 'Free',
                    'description' => 'Доступно всем',
                    'slug' => 'F',
                ]
            ],
        ];

        foreach ($roles as $role) {
            $newRole = Role::updateOrCreate($role['data']);
            if (isset($role['permission'])) {
                $dataPermission = Permission::whereIn('slug', $role['permission'])->get();
                $newRole->permissions()->sync($dataPermission);
                $newRole->save();
            }
        }
    }
}
