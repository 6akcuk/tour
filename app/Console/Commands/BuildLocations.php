<?php

namespace App\Console\Commands;

use App\Jobs\ATLASService;
use Illuminate\Console\Command;

class BuildLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild locations.';

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
     * @param ATLASService $ATLASService
     * @return mixed
     */
    public function handle(ATLASService $ATLASService)
    {
        $states = $ATLASService->states();
    }
}
