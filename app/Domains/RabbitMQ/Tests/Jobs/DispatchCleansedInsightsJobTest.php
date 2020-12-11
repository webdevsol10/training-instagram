<?php

namespace App\Domains\RabbitMQ\Tests\Jobs;

use Mockery;
use App\Data\Models\Account;
use Vinelab\Bowler\Producer;
use App\Data\Collections\MediaCollection;
use App\Domains\Transform\Jobs\ComposeInsightsModelJob;
use App\Domains\RabbitMQ\Jobs\DispatchCleansedInsightsJob;
use Tests\TestCase;

class DispatchCleansedInsightsJobTest extends TestCase
{
    public function test_dispatch_cleansed_insights_job()
    {
        $rawAccount = unserialize(file_get_contents(base_path('tests/resources/account.txt')));
        $rawContent = unserialize(file_get_contents(base_path('tests/resources/content.txt')));

        $account = Account::makeFromScraper($rawAccount);
        $medias = MediaCollection::makeFromScraper($rawContent);

        $insights = (new ComposeInsightsModelJob($account, $medias))->handle();

        $mProducer = Mockery::mock(Producer::class);
        $mProducer->shouldReceive('setup')->with('instagram_insights');
        $mProducer->shouldReceive('send')
            ->with(json_encode($insights->toArray()), 'cleansed.instagram.insights');

        $job = new DispatchCleansedInsightsJob($insights);
        $job->handle($mProducer);
    }
}
