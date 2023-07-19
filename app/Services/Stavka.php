<?php

namespace App\Services;

use App\Models\Matches;
use Carbon\Carbon;
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
                    "regex" => "div class=\"PaginationContainer\"(.*?)<div class=\"Socials social-links Socials--line\"",
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
                    "value" => "[% FOREACH item IN p1.cards;\n    author = item.card.match('(?s)<div class=\"text-h5 name[^>]+>\\s*(.*?)\\s*<svg').0;\n    roi = item.card.match('(?s)<span class=\"roi__count[^>]+>\\s*(.*?)\\s*</span>').0;\n    date_event = item.card.match('(?s)<span class=\"date__day[^>]+>\\s*(.*?)\\s*</span>').0;\n    time_event = item.card.match('(?s)<span class=\"date__time[^>]+>\\s*(.*?)\\s*</span>').0;\n    team_home = item.card.match('(?s)<span class=\"team team--home[^>]+>\\s*(.*?)\\s*</span>').0;\n    team_away = item.card.match('(?s)<span class=\"team team--away[^>]+>\\s*(.*?)\\s*</span>').0;\n    odds = item.card.match('(?s)<div class=\"Rate rate Rate--pending Rate--medium[^>]+>\\s*(.*?)\\s*</div>').0;\n    bet = item.card.match('(?s)<div class=\"header[^>]+><div class=\"Rate rate Rate--pending Rate--medium[^>]+>.*?</div>\\s*(.*?)\\s*</div>').0;\n    forecast = item.card.match('(?s)<div class=\"prediction-text text-article[^>]+>\\s*(.*?)\\s*</div>').0;\n    like = item.card.match('(?s)<button class=\"like[^>]+>.*?<span class=\"count[^>]+>\\s*(.*?)\\s*</span>').0;\n    dislike = item.card.match('(?s)<button class=\"dislike[^>]+>.*?<span class=\"count[^>]+>\\s*(.*?)\\s*</span>').0;\n    date_publish = item.card.match('(?s)<div class=\"info-date[^>]+>\\s*(.*?)\\s*</div>').0;\n   images_home = item.card.match('(?s)class=\"ContentImage__wrapper logos__item\"><img .+? srcset=\"([^\"]+)').0;\n    images_away = item.card.match('(?s)class=\"ContentImage__wrapper logos__item\"><img .+? srcset=\"([^\"]+)').1;\n\n    tools.CSVline(author,roi,date_event,time_event,team_home,team_away,odds,bet,forecast,like,dislike,date_publish);\nEND %]"
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
        "resultsPrepend" => "[% tools.CSVline('author','roi','date_event','time_event','team_home','team_away','odds','bet','forecast','like','dislike','date_publish') %]",
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
     * Приводим данные к нужному формату
     * @param $event_id
     * @return void
     */
    public function constructorData(int $event_id) : void
    {
        $result = [];
        foreach ($this->data AS $key => $row){
            if($key) {
                $joinArray = array_combine($this->data[0], $row);
                $joinArray["event_id"] = $event_id;
                $joinArray["roi"] = (float) preg_replace('/[^0-9.\-]/', '', $joinArray["roi"]);
                $joinArray["matches"] = $joinArray["team_home"] . ' - ' . $joinArray["team_away"];
                $joinArray["odds"] = (float) preg_replace('/[^0-9.\-]/', '', $joinArray["odds"]);
                $joinArray["date_event"] = self::getFormatDateFromString($joinArray["date_event"], $joinArray["time_event"]);
                $joinArray["date_publish"] = self::getFormatDateFromTodayAndYesterday($joinArray["date_publish"]);
                $result[] = $joinArray;
            }
        }
        $this->data = $result;
    }

    /**
     * Получаем дату из строки
     * @param string $date
     * @param string $time
     * @return string
     */
    protected static function getFormatDateFromString(string $date, string $time): string
    {
        $mother = ['янв' => 1,'фев' => 2,'мар' => 3,'апр' => 4,'май' => 5,'июн' => 6,'июл' => 7,'авг' => 8,'сен' => 9,'окт' => 10,'ноя' => 11,'дек' => 12];
        $arrData = explode(' ', $date . ' ' . date('Y'));
        $arrTime = explode(':', $time);
        $newData = Carbon::create((int)$arrData[2], $mother[$arrData[1]], (int)$arrData[0], $arrTime[0], $arrTime[1], 0,'Europe/London');
        return $newData->toDateTimeString();
    }

    /**
     * Получаем дату из строки формата сегодня завтра
     * @param string $date
     * @return string
     */
    protected static function getFormatDateFromTodayAndYesterday(string $date): string
    {
        $format = $date . ' ' . date('d') . ' ' . date('m') . ' ' . date('Y');
        $arrData = explode(' ', $format);
        $arrTime = explode(':', $arrData[2]);

        $day = (int)$arrData[3];
        if($arrData[0] !== 'Сегодня') {
            $day--;
        }
        $newData = Carbon::create((int)$arrData[5], (int)$arrData[4], $day, $arrTime[0], $arrTime[1], 0, 'Europe/London');
        return $newData->toDateTimeString();
    }
}
