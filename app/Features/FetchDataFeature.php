<?php

use App\Data\Models\Insights;

namespace App\Features;

use App\Data\Models\Account;
use Lucid\Units\Feature;
use App\Data\Collections\MediaCollection;
use App\Domains\Fetch\Jobs\FetchAccountJob;
use App\Domains\Fetch\Jobs\FetchContentJob;
use App\Domains\Transform\Jobs\ComposeInsightsModelJob;
use App\Domains\RabbitMQ\Jobs\DispatchCleansedInsightsJob;

class FetchDataFeature extends Feature
{
    private string $handle;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    public function handle()
    {
        // Fetch
         /* @var $account Account */
        $account = $this->run(FetchAccountJob::class, [
            'handle' => $this->handle,
        ]);

        /* @var $content MediaCollection */
        $content = $this->run(FetchContentJob::class, [
            'handle' => $this->handle,
        ]);

        // Transform
        /* @var $insights Insights */
        $insights = $this->run(ComposeInsightsModelJob::class, [
            'account' => $account,
            'medias' => $content,
        ]);

        // Dispatch
        $this->run(DispatchCleansedInsightsJob::class, compact('insights'));
    }
}
