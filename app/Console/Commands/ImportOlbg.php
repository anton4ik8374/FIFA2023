<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\Matches;
use App\Models\Teams;
use App\Models\Forecasts;
use App\Services\InterfaceServices;
use App\Services\Stavka;
use Illuminate\Console\Command;


class ImportOlbg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:olbg {load=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импортирует данные из olbg.tv';


    /**
     * отдаём команду на загрузку a-paeser
     * @var bool
     */
    public bool $load = false;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->load = $this->argument('load');
        if($this->load){
            $olbg = new Olbg();
            if($olbg instanceof InterfaceServices) {
                $olbg->load();
                if($olbg->uuid){
                    Events::add(['external_id' => $olbg->uuid, 'name' => env('SITE_OLBG_NAME')]);
                }
            }
        }
        else{
            $olbg = new Olbg();
            if($olbg instanceof InterfaceServices) {
                $events = Events::getUnprocessed(env('SITE_OLBG_NAME'));
                foreach ($events as $event){
                    if($event->external_id) {
                        $import = $olbg->import($event->external_id, $event->id);
                        if ($import && count($olbg->data)) {
                            $olbg->constructorData($event->id);
                            foreach ($olbg->data as $key => &$row) {
                                list($row['team_home_id'], $row['team_away_id']) = Teams::doAdd($row);
                                $row['matche_id'] = Matches::doAdd($row);
                                Forecasts::doAdd($row);
                            }
                        }
                        $event->status = true;
                        $event->save();
                    }
                }
            }
        }
    }

}
