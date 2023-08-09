<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatchesController extends Controller
{

    public function getActualMatches(): \Illuminate\Http\JsonResponse
    {
        $currentTime = Carbon::now()->setTimezone(config('app.timezone'));
        $matches = Matches::with(['teamsAway', 'teamHome', 'league', 'result'])->withCount('forecasts')->where('date_event', '>=', $currentTime)->get();
        foreach ($matches as &$matche) {
            $matche["statistics"] = $matche->resultTypeAll();
        }
        return response()->json($matches, 200);
    }

    public function getMatch(Request $request): \Illuminate\Http\JsonResponse
    {
        $matche = Matches::with(['teamsAway', 'teamHome', 'league', 'result', 'forecasts'])->withCount('forecasts')->find($request->id);
        $matche['statistics'] = $matche->forecasts()->groupBy('bet')->selectRaw('bet, count(*) as total, avg(odds) as odds')->orderByDesc('total')->get();

        return response()->json($matche, 200);
    }
}
