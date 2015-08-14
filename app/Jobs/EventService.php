<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class EventService extends ProductService implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ATLASService $ATLASService, $model = null)
    {
        parent::__construct($ATLASService, $model);
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

    public function isFree()
    {
        return $this->model['freeEntryFlag'] == 1;
    }

    public function getRateFrom()
    {
        $costs = [];
        foreach ($this->model['entryCosts'] as $cost) {
            $costs[] = $cost['entryCost'];
        }

        return sizeof($costs) ? (int) min($costs) : 0;
    }

    public function getFrequencyId()
    {
        return $this->model['attributeIdFrequency'];
    }

    public function getFrequencyStart()
    {
        return $this->model['frequencyStartDate'];
    }

    public function getFrequencyEnd()
    {
        return $this->model['frequencyEndDate'];
    }

    public function getOpenTimes()
    {
        return $this->model['openTimes'];
    }
}
