<?php

namespace App\Services;

class Translate extends ServiceAPI
{
    protected string $target_language = 'ru';
    protected string $folder_id = 'b1gmdhaor8b36dm6ot9r';

    public string $url = 'https://translate.api.cloud.yandex.net/translate/v2/translate';



    public function __construct($texts = ''){
        $this->token = env('YANDEX_API_TOKEN', '');
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
            "targetLanguageCode" => $this->target_language,
            "texts" => $this->texts,
            "folderId" => $this->folder_id,
        ];
        $this->post_data = json_encode($post_data);

        return $this;
    }
}
