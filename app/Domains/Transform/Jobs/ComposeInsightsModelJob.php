<?php

namespace App\Domains\Transform\Jobs;

use Lucid\Units\Job;
use App\Data\Models\Account;
use App\Data\Models\Insights;
use App\Data\Collections\MediaCollection;

class ComposeInsightsModelJob extends Job
{
    private Account $account;
    private MediaCollection $medias;

    public function __construct(Account $account, MediaCollection $medias)
    {
        $this->account = $account;
        $this->medias = $medias;
    }

    public function handle(): Insights
    {
        return Insights::makeFromScraper($this->account, $this->medias);
    }
}
