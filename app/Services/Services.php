<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

abstract class Services implements InterfaceServices
{

    public static string $status = 'completed';
    /**
     * @var array
     */
    public array $template_request = [];
    /**
     * @var array
     */
    public array $data = [];

    /**
     * @var string
     */
    public string $url = '';

    /**
     * @var Aparser
     */
    public Aparser $aparser;

    /**
     * @var string|null
     */
    public string|null $uuid = null;

    public function __construct(){
        $this->url = env('A_PARSER_DOMEN', 'http://127.0.0.1') . ':' . env('A_PARSER_PORT', 9091) . '/' . env('A_PARSER_URI', 'API');
        $this->aparser = new Aparser($this->url, env('A_PARSER_PAS', ''));
    }

    /**
     * Запускаем процесс сбора данных a-parser
     * @return void
     */
    abstract public function load() : void;

    /**
     * Получаем данные из a-parser и записываем в БД
     * @param $uuid
     * @param $event_id
     * @return bool
     */
    public function import($uuid, $event_id) : bool
    {
        $result = false;
        try {
            $this->data = [];
            if($uuid && $this->aparser instanceof Aparser) {
                $data['file'] = $this->aparser->getTaskResultsFile($uuid);
                $status = $this->aparser->getTaskState($uuid);
                if($status['status'] === self::$status) {
                    $result = true;
                    if ($data['file']) {
                        $file = fopen($data['file'], 'r', false);
                        while (($buffer = fgetcsv($file, 99999, ',')) !== false) {
                            $this->data[] = $buffer;
                        }
                        fclose($file);
                        $this->aparser->deleteTaskResultsFile($uuid);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('IMPORT ERROR: ' . $e->getMessage());
        }
        return $result;
    }

    abstract public function constructorData(int $event_id) : void;
}
