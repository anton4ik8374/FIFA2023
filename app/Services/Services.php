<?php

namespace App\Services;

abstract class Services implements InterfaceServices
{
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
     */
    abstract public function import($uuid) : void;
}
