<?php

namespace App\Services;

abstract class ServiceAPI
{
    protected string $token = '';
    public array $texts;

    public array $headers = [];
    public string $post_data = '';

    public $result = [];

    public string $url = '';


    public function setText($text) : void{
        $this->texts[] = $text;
    }
    public function clearData() : void{
        $this->result = [];
    }

    /*
     *
     */
    abstract public function init() : ServiceAPI;

    public function send() : void{
        if($this->url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl, CURLOPT_VERBOSE, 1);
            if ($this->post_data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $this->post_data);
            }
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_POST, true);

            $this->result = curl_exec($curl);

            curl_close($curl);
        }
    }
}
