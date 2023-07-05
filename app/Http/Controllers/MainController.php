<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Aparser;
class MainController extends Controller
{
    public function main()
    {
        return view('app');
    }
    public function test()
    {
        $data = [];
        $aparser = new Aparser('http://a_parser:9091/API', '123');

        echo $aparser->ping();
        dd($aparser->info());

         return response()->json($data, 200);
    }
}
