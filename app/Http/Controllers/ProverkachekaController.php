<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cheque;
use App\Models\ProductType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ProverkachekaController extends Controller
{
    public static array $codes = [
        0 =>  ['name' => 'Чек некорректен', 'status' => false],
        1 =>  ['name' => 'Данные чека получены (успешный запрос)', 'status' => true],
        2 =>  ['name' => 'Данные чека пока не получены', 'status' => false],
        3 =>  ['name' => 'Превышено кол-во запросов', 'status' => false],
        4 =>  ['name' => 'Ожидание перед повторным запросом', 'status' => false],
        5 =>  ['name' => 'Прочее (данные не получены)', 'status' => false],
    ];
    public function getCheck(Request $request)
    {
        try {
            //$useRequest['qrraw'] = 't=20230424T1858&s=1340.79&fn=9960440503166309&i=66363&fp=2591917906&n=1';
            $useRequest = $request->all();
            $data = [
                'token' => env('API_KEY_PROVERKACHEKA','21224.KuaCYAGmFLaxOjKKI'),
                'qr' => '0',
            ];
            $qrData = explode('&', $useRequest['qrraw']);
            foreach($qrData as $row){
                $timeData = explode('=',$row);
                if($timeData[0] === 'i'){
                    $data['fd'] = $timeData[1];
                }else {
                    $data[$timeData[0]] = $timeData[1];
                }
            }

            $searchCheque = Cheque::search($data)->first();
            $resultJson = null;
            if(!$searchCheque) {
                $url = env('URL_PROVERKACHEKA', 'https://proverkacheka.com/api/v1/check/get');
                //выполняем запрос на сервер Проверка чека используя API
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $resultJson = curl_exec($curl);
                curl_close($curl);

                $result = json_decode($resultJson, true);

                //Получаем метку времени
                $year = substr($data['t'], 0, 4);
                $mother = substr($data['t'], 4, 2);
                $day = substr($data['t'], 6, 2);
                $hour = substr($data['t'], 9, 2);
                $minut = substr($data['t'], 11, 2);
                $seconds = 0;

                $time = Carbon::create($year, $mother, $day, $hour, $minut, $seconds, 'Europe/Moscow');

                $chequeData = [
                    'query_request' => json_encode($data, true),
                    'response' => json_encode($result, true),
                    'response_code' => $result['code'],
                    'price' => $data['s'],
                    'is_credit' => $request->is_credit,
                    'date_cheque' => $time
                ];
                $cheque = Cheque::add($chequeData);

                if (self::$codes[(int)$result['code']] && self::$codes[(int)$result['code']]['status']) {
                        foreach ($result['data']['json']['items'] as $product){
                            $newProduct = [
                                'name' => $product['name'],
                                'price' => (float)(substr($product['price'], 0, -2) . '.' . substr($product['price'], -2, 2)),
                                'sum' => (float)(substr($product['sum'], 0, -2) . '.' . substr($product['sum'], -2, 2)),
                                'count' => $product['quantity'],
                                'description' => '',
                                'cheque_id' => $cheque->id,
                                'type_id' => ProductType::$typeOther,
                                'is_credit' => $request->is_credit
                            ];
                            $currentProduct = Product::where($newProduct)->first();
                            if($currentProduct){
                               //...
                            }else {
                                Product::add($newProduct);
                            }
                        }
                } else {
                    //...
                }
                return response()->json(['message' => self::$codes[(int)$result['code']]['name']], 200);
            }

            return response()->json(['message' => 'Чек уже был обработан ранее.'], 300);
        } catch (\Throwable $e) {
            return response($e->getMessage(), 500);
        }
    }
}
