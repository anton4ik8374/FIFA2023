<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Services\InterfaceServices;
use App\Services\Stavka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Aparser;

class MainController extends Controller
{
    public function main()
    {
        return view('app');
    }

    public function testA()
    {
        $data = [];
        $stavka = new Stavka();
        if($stavka instanceof InterfaceServices) {
            $stavka->load();
            if($stavka->uuid){
                Events::add(['external_id' => $stavka->uuid, 'name' => 'stavka.tv']);
            }
            $data['message'] = "UUID процесса {$stavka->uuid}";
        }

        return response()->json($data, 200);
    }
    public function testB(Request $request)
    {
        $data = [];
        if ($request->uuid) {
            $stavka = new Stavka();
            if ($stavka instanceof InterfaceServices) {
                $events = Events::getUnprocessed();
                foreach ($events as $event){
                    if($event->external_id) {
                        $stavka->import($event->external_id);
                        $event->status = true;
                        $event->save();
                    }
                }
                if (count($stavka->data)) {
                    $data['content'] = $stavka->data;
                    $data['message'] = 'Данные получены';
                }
            }
        } else {
            $data['message'] = 'Не передан uuid';
        }
        return response()->json($data, 200);
    }

}
