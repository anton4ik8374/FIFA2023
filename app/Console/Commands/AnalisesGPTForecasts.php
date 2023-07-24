<?php

namespace App\Console\Commands;

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
                    $result = ['teams','odds','forecast'];
                    $forecasts = $matche?->forecasts();
                    $count_forecasts = 0;
                    foreach ($forecasts as $forecast){
                        /**
                         * Для сайта olbg.com т.к. мы получаем от них суммированный результат
                         */
                        if($matche->events->name === env('SITE_OLBG_NAME', '') && $forecast->win_tips > 1){
                            for($i = 0; $i <= $forecast->win_tips; $i++){
                                $result[] = 'Team1-Team2, ' . $forecast->odds . ', ' . $forecast->bet;
                            }
                            $count_forecasts += $forecast->win_tips;
                        }else{
                            $result[] = 'Team1-Team2, ' . $forecast->odds . ', ' . $forecast->bet;
                            $count_forecasts += 1;
                        }
                    }
                    if ($client) {
                        $question = env('GPT_CHAT_QUESTION','');
                        $query = $question . ' \n ' .  '"""' . implode('\n ', $result) . '"""';
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
                                if($team1){
                                    $newRes['win_team_id'] = $matche->team_home_id;
                                }elseif ($team2){
                                    $newRes['win_team_id'] = $matche->team_away_id;
                                }elseif ($Draw){
                                    $teamDrawn = Teams::getDrawn();
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
    }

}
