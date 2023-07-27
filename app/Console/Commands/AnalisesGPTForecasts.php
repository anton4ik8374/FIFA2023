<?php

namespace App\Console\Commands;

use App\Helpers\CountTokens;
use App\Models\Events;
use App\Models\Matches;
use App\Models\Results;
use App\Models\Teams;
use App\Models\Forecasts;
use App\Services\InterfaceServices;
use App\Services\Stavka;
use App\Services\StavkaV2;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class AnalisesGPTForecasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:gpt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Анализ прогнозов ChatGPT';


    /**
     *
     * @var bool
     */
    public bool $load = false;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
                                $result[] = 'Team1-Team2, ' . $forecast->odds . ', ' . $bet;
                            }
                            $count_forecasts += $forecast->win_tips;
                        }else{
                            $bet = str_replace('w2','win Team2',str_replace('w1','win Team1', str_replace('_', ' ', $forecast->bet)));
                            $bet = str_replace('t2','Team2',str_replace('t1','Team1', $bet));
                            $result[] = 'Team1-Team2, ' . $forecast->odds . ', ' . $bet;
                            ++$count_forecasts;
                        }
                        /**
                         * TODO когда проверка при помощи Python на токены будет доработана можно расскоментировать
                         */
                        /*if(CountTokens::count($query) > 4000){
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
                                $Draw = str_contains($newRes['chat_gpt_result'], 'Draw');
                                $countWin = 0;
                                if($team1){
                                    $newRes['win_team_id'] = $matche->team_home_id;
                                    $countWin = explode('Team1:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
                                }elseif ($team2){
                                    $newRes['win_team_id'] = $matche->team_away_id;
                                    $countWin = explode('Team2:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
                                }elseif ($Draw){
                                    $teamDrawn = Teams::getDrawn();
                                    $newRes['win_team_id'] = $teamDrawn->id;
                                    $countWin = explode('Draw:', $newRes['chat_gpt_result']);
                                    $newRes['count_forecasts_win'] = isset($countWin[1]) ? (int)$countWin[1] : 0;
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
    }

}
