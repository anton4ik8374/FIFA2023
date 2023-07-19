<?php

namespace App\Services;

class ChatGPT extends ServiceAPI
{

    public string $url  = 'https://api.openai.com/v1/completions';
    public string $urlModel  = 'https://api.openai.com/v1/models';

    public function __construct($texts = ''){
        $this->token = env('CHAT_GPT_API_KEY', '');
        if($texts) {
            $this->texts = $texts;
        }
        if($this->token){
            $this->headers  = [
                'Content-Type: application/json',
                "Authorization: Bearer $this->token"
            ];
        }
    }

    public function init(): ServiceAPI
    {
        $post_data = [
            "model" => "text-davinci-003",
            "prompt" => "What time is it",
            "max_tokens" => 20
        ];
        $this->post_data = json_encode($post_data, JSON_THROW_ON_ERROR);

        return $this;

    }

    public function getModel(){
        if($this->urlModel) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $this->urlModel);
            $this->result = curl_exec($curl);
            curl_close($curl);
        }
    }


}
