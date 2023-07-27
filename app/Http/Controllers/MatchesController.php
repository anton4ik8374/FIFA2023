<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatchesController extends Controller
{

    public function getActualMatches(){
        $currentTime = Carbon::now()->setTimezone(config('app.timezone'));
        $matches = Matches::with(['teamsAway', 'teamHome', 'league', 'result'])->withCount('forecasts')->where('date_event', '>=', $currentTime)->get();
        return response()->json($matches, 200);
    }
}
