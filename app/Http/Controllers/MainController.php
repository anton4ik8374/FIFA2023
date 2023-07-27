<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Forecasts;
use App\Models\JobImport;
use App\Models\Leagues;
use App\Models\Matches;
use App\Models\Results;
use App\Models\Teams;
use App\Services\InterfaceServices;
use App\Services\Olbg;
use Illuminate\Http\Request;
use App\Services\StavkaV2;
use App\Helpers\CountTokens;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function main()
    {
        return view('app');
    }

    public function chat(){
        try{
            $matches = Matches::getActualMach();
            if($matches) {
                $client = \OpenAI::client(env('OPENAI_API_KEY', ''));
                foreach ($matches as $matche) {
                    $question = env('GPT_CHAT_QUESTION','');
                    $query = $question . ' ' . '"""teams,odds,forecast;';
                    $forecasts = $matche?->forecasts;
                    $count_forecasts = 0;
                    foreach ($forecasts as $key => $forecast){
                        /**
                         * Для сайта olbg.com т.к. мы получаем от них суммированный результат
                         */
                        if($matche->events->name === env('SITE_OLBG_NAME', '') && $forecast->win_tips > 1){
                            for($i = 0; $i <= $forecast->win_tips; $i++){
                                $bet = str_replace('w2','win Team2',str_replace('w1','win Team1', str_replace('_', ' ', $forecast->bet)));
                                $bet = str_replace('t2','Team2',str_replace('t1','Team1', $bet));
                                $query .= 'Team1-Team2, ' . $forecast->odds . ', ' . $bet . ';';
                            }
                            $count_forecasts += $forecast->win_tips;
                        }else{
                            $bet = str_replace('w2','win Team2',str_replace('w1','win Team1', str_replace('_', ' ', $forecast->bet)));
                            $bet = str_replace('t2','Team2',str_replace('t1','Team1', $bet));
                            $query .= 'Team1-Team2, ' . $forecast->odds . ', ' . $bet  . ';';
                            ++$count_forecasts;
                        }
                        /**
                         * TODO когда проверка при помощи Python на токены будет доработана можно расскоментировать
                         */
                       /* if(CountTokens::count($query) > 4000){
                            break;
                        }*/
                        /**
                         * TODO искуственное ограничение в 100 прогнозов чтобы не привышать лимит 4000 токенов
                         * токены являются строительными блоками текста. Они могут быть как короткими, как один символ, так и длинными, как одно слово, в зависимости от языка.
                         */
                        if($key >= 100){
                            break;
                        }
                    }
                    $query .= '"""';

                    if ($client) {
                        $resultGpt = $client->completions()->create([
                            'model' => 'text-davinci-003',
                            'prompt' => $query
                        ]);
                        if($resultGpt['choices'][0]['text']){
                            $res = Results::whereMatcheId($matche->id)->first();
                            $newRes = [
                                'chat_gpt_result' => trim($resultGpt['choices'][0]['text']),
                                'count_forecasts' => $count_forecasts
                            ];
                            if($newRes['chat_gpt_result']){
                                $team1 = str_contains($newRes['chat_gpt_result'], 'Team1') ? : str_contains($newRes['chat_gpt_result'], 'Team 1');
                                $team2 = str_contains($newRes['chat_gpt_result'], 'Team2') ? : str_contains($newRes['chat_gpt_result'], 'Team 2');
                                $draw = str_contains($newRes['chat_gpt_result'], 'Draw');
                                $countWin = 0;
                                if($team1){
                                    $newRes['win_team_id'] = $matche->team_home_id;
                                    $countWin = explode('Team1:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
                                }elseif ($team2){
                                    $newRes['win_team_id'] = $matche->team_away_id;
                                    $countWin = explode('Team2:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
                                }elseif ($draw){
                                    $teamDrawn = Teams::getDrawn();
                                    $countWin = explode('Draw:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
                                    $newRes['win_team_id'] = $teamDrawn->id;
                                }
                            }
                            if(!$res) {
                                $newRes['matche_id'] = $matche->id;
                                Results::add($newRes);
                            }else{
                                $res->edit($newRes);
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('ChatGPT API: ' . $e->getMessage());
        }
        $data['message'] = 'Прогнозы обработаны';
        return response()->json($data, 200);
    }
    public function stavka()
    {
        $data = [];
        $name = env('SITE_STAVKA_NAME');
        $imports = JobImport::whereSite($name)->whereActual(true)->get();
        if($imports) {
            foreach ($imports as $import) {
                $event = Events::add(['name' => $import->site]);
                if ($event) {
                    $stavka = new StavkaV2($event->id, $import->slug_league);
                    if ($stavka) {
                        $stavka->load();
                        if (!!$stavka->result && count($stavka->result)) {
                            $stavka->import();
                            $event->edit(['status' => true]);
                        }
                        $data['message'] = "Ппроцесса {$name} завершон";
                    }
                }
            }
        }

        return response()->json($data, 200);
    }
    public function olbg()
    {
        $data = [];
        $name = env('SITE_OLBG_NAME', '');
        $imports = JobImport::whereSite($name)->get();
        if($imports) {
            foreach ($imports as $import) {
                $olbg = new Olbg($import->slug_league);
                if ($olbg instanceof InterfaceServices) {
                    $olbg->load();
                    if ($olbg->uuid) {
                        Events::add(['external_id' => $olbg->uuid, 'name' => $import->site]);
                    }
                    $data['message'] = "UUID процесса {$name} {$olbg->uuid}";
                }
            }
        }

        return response()->json($data, 200);
    }
    public function import(Request $request)
    {
        $data = [];
        if ($request->uuid) {
                $events = Events::getUnprocessed(env('SITE_OLBG_NAME'));
                foreach ($events as $event){
                    if($event->external_id) {
                        $object = false;
                        if($event->name === env('SITE_OLBG_NAME')){
                            $object = new Olbg($event->name);
                        }elseif($event->name === env('SITE_STAVKA_NAME')){
                            $object = new StavkaV2();
                        }
                        if($object) {
                            $import = $object->import($event->external_id, $event->id);
                            if ($import && count($object->data)) {
                                $object->constructorData($event->id);
                                foreach ($object->data as $key => &$row) {
                                    list($row['team_home_id'], $row['team_away_id']) = Teams::doAdd($row);
                                    if (isset($row['league'])){
                                        $row['league_id'] = Leagues::doAdd($row);
                                    }
                                    $row['matche_id'] = Matches::doAdd($row);
                                    Forecasts::doAdd($row);
                                    $data['content'][] = $row;
                                }
                                $data['message'] = 'Данные получены';
                            }else{
                                $data['message'] = 'Файл не готов';
                            }
                        }else{
                            $data['message'] = 'Ошибка создания парсера';
                        }
                    }
                    $event->status = true;
                    $event->save();
                }

        } else {
            $data['message'] = 'Не передан uuid';
        }
        return response()->json($data, 200);
    }

}
