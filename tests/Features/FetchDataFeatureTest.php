<?php

namespace App\Tests\Features;

use Mockery;
use Tests\TestCase;
use App\Data\Models\Account;
use App\Features\FetchDataFeature;
use App\Data\Collections\MediaCollection;
use App\Domains\Fetch\Jobs\FetchAccountJob;
use App\Domains\Fetch\Jobs\FetchContentJob;

class FetchDataFeatureTest extends TestCase
{
    public function test_fetching_data()
    {
        $handle = 'third_eye_thirst';

        $f = Mockery::mock(new FetchDataFeature($handle))->makePartial();

        $rawAccount = unserialize(file_get_contents(base_path('/tests/resources/account.txt')));
        $f->shouldReceive('run')
            ->with(FetchAccountJob::class, compact('handle'))
            ->andReturn(Account::makeFromScraper($rawAccount));

        $rawContent = unserialize(file_get_contents(base_path('tests/resources/content.txt')));
        $f->shouldReceive('run')
            ->with(FetchContentJob::class, compact('handle'))
            ->andReturn(MediaCollection::makeFromScraper($rawContent));

        $f->handle();
    }
}
