<?php

namespace App\Http\Controllers;

use App\Models\Leagues;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{

    public function getLeagues(){

        $Leagues = Leagues::all();
        return response()->json($Leagues, 200);
    }
}
