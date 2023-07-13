<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Stavka extends Services
{
    public array $template_request =  [
        "preset" => "stavka.tv true",
        "configPreset" => "100 Threads",
        "parsers" => [
            [
                "Net::HTTP",
                "test1",
                [
                    "type" => "options",
                    "id" => "checkNextPage",
                    "value" => " aria-current=\"page[^>]+>\\s*\\d*\\s*<\\/a><a href=\"(.+?)\" class=\"nav-button",
                    "additional" => [
                        "checkNextPageLimit" => "0"
                    ]
                ],
                [
                    "type" => "override",
                    "id" => "user-agent",
                    "value" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 YaBrowser/23.5.4.674 Yowser/2.5 Safari/537.36"
                ],
                [
                    "type" => "customResult",
                    "result" => [
                        "pages",
                        "data"
                    ],
                    "regex" => "<div class=\"container\"(.*?)class=\"Pagination Pagination--with-join\"",
                    "regexType" => "s",
                    "resultType" => "array",
                    "arrayName" => "block",
                    "results" => [
                        "data"
                    ]
                ],
                [
                    "type" => "override",
                    "id" => "goodCode",
                    "value" => [
                        200
                    ]
                ],
                [
                    "type" => "override",
                    "id" => "useproxy",
                    "value" => false
                ],
                [
                    "type" => "options",
                    "id" => "checkContent",
                    "value" => "div class=\"PaginationContainer\"",
                    "additional" => [
                        "checkContentMatchType" => 1
                    ]
                ],
                [
                    "type" => "customResult",
                    "result" => [
                        "block",
                        "data"
                    ],
                    "regex" => "<div class=\"PredictionsItem prediction PredictionsItem--coming\"(.*?)<div class=\"footer\"",
                    "regexType" => "sg",
                    "resultType" => "array",
                    "arrayName" => "cards",
                    "results" => [
                        "card"
                    ]
                ],
                [
                    "type" => "override",
                    "id" => "formatresult",
                    "value" => "[% FOREACH item IN p1.cards;\n    name = item.card.match('(?s)<div class=\"text-h5 name[^>]+>\\s*(.*?)\\s*<svg').0;\n    roi = item.card.match('(?s)<span class=\"roi__count[^>]+>\\s*(.*?)\\s*</span>').0;\n    date_event = item.card.match('(?s)<span class=\"date__day[^>]+>\\s*(.*?)\\s*</span>').0;\n    time_event = item.card.match('(?s)<span class=\"date__time[^>]+>\\s*(.*?)\\s*</span>').0;\n    team_home = item.card.match('(?s)<span class=\"team team--home[^>]+>\\s*(.*?)\\s*</span>').0;\n    team_away = item.card.match('(?s)<span class=\"team team--away[^>]+>\\s*(.*?)\\s*</span>').0;\n    rate = item.card.match('(?s)<div class=\"Rate rate Rate--pending Rate--medium[^>]+>\\s*(.*?)\\s*</div>').0;\n    header = item.card.match('(?s)<div class=\"header[^>]+><div class=\"Rate rate Rate--pending Rate--medium[^>]+>.*?</div>\\s*(.*?)\\s*</div>').0;\n    forecast = item.card.match('(?s)<div class=\"prediction-text text-article[^>]+>\\s*(.*?)\\s*</div>').0;\n    like = item.card.match('(?s)<button class=\"like[^>]+>.*?<span class=\"count[^>]+>\\s*(.*?)\\s*</span>').0;\n    dislike = item.card.match('(?s)<button class=\"dislike[^>]+>.*?<span class=\"count[^>]+>\\s*(.*?)\\s*</span>').0;\n    date_publish = item.card.match('(?s)<div class=\"info-date[^>]+>\\s*(.*?)\\s*</div>').0;\n\n    tools.CSVline(name,roi,date_event,time_event,team_home,team_away,rate,header,forecast,like,dislike,date_publish);\nEND %]"
                ]
            ]
        ],
        "resultsFormat" => '$p1.preset',
        "resultsSaveTo" => "file",
        "resultsFileName" => '$datefile.format().csv',
        "additionalFormats" => [],
        "resultsUnique" => "no",
        "queriesFrom" => "text",
        "queryFormat" => [
            '$query'
        ],
        "uniqueQueries" => false,
        "saveFailedQueries" => false,
        "iteratorOptions" => [
            "onAllLevels" => false,
            "queryBuildersAfterIterator" => false,
            "queryBuildersOnAllLevels" => false
        ],
        "resultsOptions" => [
            "overwrite" => true,
            "writeBOM" => false
        ],
        "doLog" => "no",
        "limitLogsCount" => "0",
        "keepUnique" => "No",
        "moreOptions" => true,
        "resultsPrepend" => "[% tools.CSVline('name','roi','date_event','time_event','team_home','team_away','rate','header','forecast','like','dislike','date_publish') %]",
        "resultsAppend" => "",
        "queryBuilders" => [],
        "resultsBuilders" => [
            [
                "source" => [
                    0,
                    [
                        "cards",
                        "card"
                    ]
                ],
                "type" => "decodeHtml",
                "array" => "cards",
                "to" => "card"
            ],
            [
                "source" => [
                    0,
                    [
                        "cards",
                        "card"
                    ]
                ],
                "type" => "regexReplace",
                "array" => "cards",
                "regex" => "(<!---->)",
                "regexType" => "g",
                "replace" => "",
                "to" => "card"
            ]
        ],
        "configOverrides" => [],
        "runTaskOnComplete" => null,
        "useResultsFileAsQueriesFile" => false,
        "runTaskOnCompleteConfig" => "default",
        "toolsJS" => "",
        "prio" => 5,
        "removeOnComplete" => false,
        "callURLOnComplete" => "",
    ];

    /**
     * @var string|null
     */
    public string|null $uuid = null;

    /**
     * Запускаем процесс сбора данных a-parser
     * @return void
     */
    public function load() : void
    {
        try {
            if ($this->aparser instanceof Aparser) {
                $this->aparser->ping();
                $this->aparser->info();
                $this->uuid = $this->aparser->addTask('default', FALSE, 'text', env('SITE_STAVKA'), $this->template_request);
            }
        } catch (\Throwable $e) {
            Log::warning('LOAD STAVKA ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Получаем данные из a-parser и записываем в БД
     * @param $uuid
     * @return void
     */
    public function import($uuid) : void
    {
        try {

            if($uuid && $this->aparser instanceof Aparser) {
                    $data['file'] = $this->aparser->getTaskResultsFile($uuid);
                    if($data['file']) {
                        $file = fopen($data['file'], 'r', false);
                        while (($buffer = fgetcsv($file, 99999, ',')) !== false) {
                            $this->data[] = $buffer;
                        }
                        fclose($file);
                        $this->aparser->deleteTaskResultsFile($uuid);
                    }
            }
        } catch (\Throwable $e) {
            Log::warning('IMPORT STAVKA ERROR: ' . $e->getMessage());
        }
    }
}
