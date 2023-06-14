<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Menu;


class MenuController extends Controller
{
    /**
     * Получаем общее меню
     * @param Request $request
     * @return object
     */
    public function getFreeMenu(Request $request) : object
    {
        $menus = Menu::getMenu(Role::SLUG_FREE);
        return response()->json($menus, 200);
    }

    /**
     * Получаем ЛК меню
     * @param Request $request
     * @return object
     */
    public function getLkMenu(Request $request) : object
    {
        $menus = Menu::getMenu(Role::SLUG_USER);
        return response()->json($menus, 200);
    }

    /**
     * Получаем Админ меню
     * @param Request $request
     * @return object
     */
    public function getAdminMenu(Request $request) : object
    {
        $menus = Menu::getMenu(Role::SLUG_ADMIN);
        return response()->json($menus, 200);
    }
}
