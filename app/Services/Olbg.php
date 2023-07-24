<?php

namespace App\Services;

use App\Models\Matches;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Olbg extends Services
{
    public array $template_request =  [
        "preset" => "olbg.com",
        "configPreset" => "100 Threads",
        "parsers" => [
            [
                "Net::HTTP",
                "test1",
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
                    "regex" => "<tbody id=\"tips-table-tbody-match\">(.*?)<\\/tbody>\\s*<\\/table>",
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
                    "value" => "tbody id=\"tips-table-tbody-match\"",
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
                    "regex" => "data-vc_sport_id=\"1\" class=\"o-tip tip-row[^>]+>(.*?)</td><!--cached-partial-end--> </tr>",
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
                    "value" => "[% FOREACH item IN p1.cards;\n    matches = item.card.match('(?s)<a class=\"tn-trigger\" data-attach-loading=\"\" data-page_type=\"event[^>]+>\\s*(.*?)\\s*</a>').0.collapse();\n    league = item.card.match('(?s)<p class=\"event-league-name\"><i class=\"icon-trophy\"></i>\\s*(.*?)\\s*</p>').0;\n    date_event = item.card.match('(?s)<p class=\"event-date\" itemprop=\"startDate\" content=\"(.*?)\"').0;\n    bet = item.card.match('(?s)class=\"selection-name \"><a class=\"tn-trigger\" data-attach-loading=\"\"[^>]+>\\s*(.*?)\\s*</a>').0;\n    odds = item.card.match('(?s)<div class=\"d-none d-lg-block odds formatted-odds[^>]+><span>\\s*(.*?)\\s*</span>').0;\n    tips = item.card.match('(?s)<p class=\"d-lg-none no-margin-bottom\">\\s*(.*?)\\s*</p>').0;\n    confidence = item.card.match('(?s)class=\"confidence-percentage__number\" data-confidence[^>]+>\\s*(.*?)\\s*</span>').0;\n\ntools.CSVline(matches,league,date_event,bet,odds,tips,confidence);\nEND %]"
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
        "resultsPrepend" => "[% tools.CSVline('matches','league','date_event','bet','odds','tips','confidence') %]",
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
                $url = env('SITE_OLBG', '') . $this->league;
                $this->uuid = $this->aparser->addTask('default', FALSE, 'text', $url, $this->template_request);
            }
        } catch (\Throwable $e) {
            Log::warning('LOAD OLBG ERROR: ' . $e->getMessage());
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

                $commands = explode(' v ', $joinArray['matches']);
                $joinArray["event_id"] = $event_id;
                $joinArray["matches"] = trim($commands[0]) . ' - ' . trim($commands[1]);
                $tips = explode(' / ', preg_replace('/[^0-9 \/]/', '', $joinArray["tips"]));
                $joinArray['team_home'] = trim($commands[0]);
                $joinArray['team_away'] = trim($commands[1]);
                $joinArray["all_tips"] =  $tips[1];
                $joinArray["type"] =  $joinArray["bet"];
                $joinArray["win_tips"] = $tips[0];
                $joinArray["confidence"] = preg_replace('/[^0-9]/', '', $joinArray["confidence"]);
                $result[] = $joinArray;
            }
        }
        $this->data = $result;
    }
}
