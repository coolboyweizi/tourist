<?php

namespace App\Console\Commands;

use App\Api\TravelData;
use Carbon\Carbon;
use Illuminate\Console\Command;


class travel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'travel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '直通车采集';

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
        for ($i=0; $i< 7; $i++) {
            $instance = new TravelData(Carbon::now()->addDay($i)->format('Y-m-d'));
            $instance->execute();
            unset($instance);
        }
    }

}
