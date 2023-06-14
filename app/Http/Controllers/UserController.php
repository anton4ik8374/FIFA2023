<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function info()
    {
        try{
            $user = [];
            if(Auth::check()) {
                $user = Auth::user();

                if($user->hasEntrance()) {
                    $user['entrance'] = $user->hasEntrance();
                }

                return response($user, 200);
            }
        } catch (\Throwable $e) {

            return response([], 500);

        }
    }
}
