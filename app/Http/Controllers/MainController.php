<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Forecasts;
use App\Models\Leagues;
use App\Models\Matches;
use App\Models\Teams;
use App\Services\ChatGPT;
use App\Services\InterfaceServices;
use App\Services\Olbg;
use App\Services\Stavka;
use App\Services\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\StavkaV2;

class MainController extends Controller
{
    public function main()
    {
        return view('app');
    }

    public function chat(){
        $item = new ChatGPT();
        $item->setText('Liverpool');
        $item->init()->send();
        #$item->send();
        $data['message'] = json_decode($item->result);
        return response()->json($data, 200);
    }
    public function stavka()
    {
        $data = [];
        $name = env('SITE_STAVKA_NAME');
        $event = Events::add(['name' => $name]);
        $stavka = new StavkaV2($event->id);
        if($stavka) {
            $stavka->load();
            if(count($stavka->result)){
                $stavka->import();
                $event->edit(['status' => true]);
            }
            $data['message'] = "Ппроцесса {$name} завершон";
        }

        return response()->json($data, 200);
    }
    public function olbg()
    {
        $data = [];
        $olbg = new Olbg();
        $name = env('SITE_OLBG_NAME');
        if($olbg instanceof InterfaceServices) {
            $olbg->load();
            if($olbg->uuid){
                Events::add(['external_id' => $olbg->uuid, 'name' => $name]);
            }
            $data['message'] = "UUID процесса {$name} {$olbg->uuid}";
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
                            $object = new Olbg();
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
