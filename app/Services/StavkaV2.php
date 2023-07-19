<?php

namespace App\Services;

use App\Models\Forecasts;
use App\Models\Leagues;
use App\Models\Matches;
use App\Models\Teams;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StavkaV2
{

    public array $headers = [];
    public string $event_id;
    public int $offset = 50;
    public $result;
    public array $params =  [
        'betOnTips' => 'false',
        'limit' => 50,
        'offset' => 0,
        'period' => '2d',
        'rateFrom' => 1
    ];

    public string $url = 'https://stavka.tv/api/v2/predictions';

    public function __construct($event_id){
            $this->event_id = $event_id;
            $this->headers  = ['Content-Type: application/json'];
    }
    public function nextOffset(){
        $this->params['offset'] += $this->offset;
    }

    protected function getUrl(){
        $uri =  $this->url . '?' . http_build_query($this->params);
        return $uri . '&sports[]=soccer&leagueSlugs[]=uefa-europa-conference-league';
    }

    public function getData() : bool|string
    {
        $result = false;
        if($this->url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_URL, $this->getUrl());

            $result = curl_exec($curl);

        }
        return $result;
    }

    public function load(){
        $result = json_decode($this->getData());

        foreach ($result->data->predictions as $item){
            $this->constructorData($item);
        }

        while($result->meta->total > $this->params['offset']){
            $this->nextOffset();
            $resultCurrent = json_decode($this->getData());

            foreach ($resultCurrent->data->predictions as $item){
                $this->constructorData($item);
            }
        }
    }

    public function constructorData($item) : void {
        $this->result[]  = [
            'event_id' => $this->event_id,
            'league' => $item->match->league->name,
            'author' => $item->predictor->lastName . ' ' . $item->predictor->firstName ,
            'roi' => $item->predictor->statistics->roi,
            'date_event' => $item->match->matchDate,
            'team_home' => $item->match->teams->home->name,
            'img_home' => env('SITE_STAVKA_SDN', '') . $item->match->teams->home->logo,
            'team_away' => $item->match->teams->away->name,
            'img_away' =>  env('SITE_STAVKA_SDN', '') . $item->match->teams->away->logo,
            'matches' => $item->match->teams->home->name . ' - ' . $item->match->teams->away->name,
            'odds' => $item->rate,
            'bet' => $item->type . ' ' . $item->outcome,
            'type' => $item->type,
            'outcome' =>$item->outcome,
            'forecast' => $item->comment,
            'like' => $item->likeCount,
            'dislike' => $item->dislikeCount,
            'date_publish' => $item->createdAt
        ];
    }


    public function import(){
        foreach ($this->result as &$result) {
            list($result['team_home_id'], $result['team_away_id']) = Teams::doAdd($result);
            if (isset($result['league'])){
                $result['league_id'] = Leagues::doAdd($result);
            }
            $result['matche_id'] = Matches::doAdd($result);
            Forecasts::doAdd($result);
        }
    }

}
