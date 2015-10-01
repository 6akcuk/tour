<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ServiceHelper extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }

    /**
     * Changes url into auto scheme
     *
     * @param $url
     * @return mixed
     */
    public function changeToAutoScheme($url)
    {
        return str_replace(['http://', 'https://'], '//', $url);
    }
}
