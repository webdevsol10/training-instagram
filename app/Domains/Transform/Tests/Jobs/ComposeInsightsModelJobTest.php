<?php

namespace App\Domains\Transform\Tests\Jobs;

use App\Data\Models\Account;
use App\Data\Models\Insights;
use App\Data\Collections\MediaCollection;
use App\Domains\Transform\Jobs\ComposeInsightsModelJob;
use Tests\TestCase;

class ComposeInsightsModelJobTest extends TestCase
{
    public function test_compose_insights_model_job()
    {
        $rawAccount = unserialize(file_get_contents(base_path('tests/resources/account.txt')));
        $rawContent = unserialize(file_get_contents(base_path('tests/resources/content.txt')));

        $account = Account::makeFromScraper($rawAccount);
        $medias = MediaCollection::makeFromScraper($rawContent);

        $job = new ComposeInsightsModelJob($account, $medias);

        $insights = $job->handle();

        // @TODO flood test with assertions!
        $this->assertInstanceOf(Insights::class, $insights);
    }
}
