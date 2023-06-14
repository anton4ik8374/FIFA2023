<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RoutesController extends Controller
{
    public function getRoutes(): \Illuminate\Http\JsonResponse
    {
        //dd(Route::getRoutes());
        $routes = [];
        foreach (Route::getRoutes() AS $route){
            $routes[$route->getName()] = $route->uri();
        }
        return response()->json($routes, 200);
    }
}
