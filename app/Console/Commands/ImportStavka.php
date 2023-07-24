<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\JobImport;
use App\Models\Matches;
use App\Models\Teams;
use App\Models\Forecasts;
use App\Services\InterfaceServices;
use App\Services\Stavka;
use App\Services\StavkaV2;
use Illuminate\Console\Command;


class ImportStavka extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:stavka {load=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импортирует данные из stavka.tv';


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
        $name = env('SITE_STAVKA_NAME', '');
        $imports = JobImport::whereSite($name)->get();
        if($imports) {
            foreach ($imports as $import) {
                $event = Events::add(['name' => $import->site]);
                if ($event) {
                    $stavka = new StavkaV2($event->id, $import->slug_league);
                    if ($stavka) {
                        $stavka->load();
                        if (!!$stavka->result && count($stavka->result)) {
                            $stavka->import();
                            $event->edit(['status' => true]);
                        }
                    }
                }
            }
        }
    }

}
