<?php

namespace App\Domains\RabbitMQ\Jobs;

use Lucid\Units\Job;
use Vinelab\Bowler\Producer;
use App\Data\Models\Insights;

class DispatchCleansedInsightsJob extends Job
{
    private Insights $insights;

    public function __construct(Insights $insights)
    {
        $this->insights = $insights;
    }

    public function handle(Producer $producer)
    {
        $producer->setup('instagram_insights');
        $producer->send(json_encode($this->insights->toArray()), 'cleansed.instagram.insights');
    }
}
