<?php

namespace App\Console\Commands;

use App\Models\Apply;
use App\Models\ApplyStatus;
use App\Models\Events;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\Subscription;
use App\Services\Aparser;
use App\Services\InterfaceServices;
use App\Services\Stavka;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Procedures;
use App\Models\ProcedureType;
use App\Models\Rebidding;
use App\Models\ProcedureStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;


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
    protected $description = 'Импортирует данные из stavka.tv/predictions/soccer';


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
            $stavka = new Stavka();
            if($stavka instanceof InterfaceServices) {
                $stavka->load();
                if($stavka->uuid){
                    Events::add(['external_id' => $stavka->uuid, 'name' => 'stavka.tv']);
                }
            }
        }
        else{
            $stavka = new Stavka();
            if($stavka instanceof InterfaceServices) {
                $events = Events::getUnprocessed();
                foreach ($events as $event){
                    if($event->external_id) {
                        $stavka->import($event->external_id);
                        $events->status = true;
                        $events->save();
                    }
                }
            }
        }
    }

}
