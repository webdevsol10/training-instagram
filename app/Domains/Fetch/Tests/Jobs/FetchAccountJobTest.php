<?php

namespace App\Domains\Fetch\Tests\Jobs;

use Mockery;
use InstagramScraper\Instagram;
use App\Domains\Fetch\Jobs\FetchAccountJob;
use Tests\TestCase;

class FetchAccountJobTest extends TestCase
{
    public function test_fetch_account_job()
    {
        $handle = 'third_eye_thirst';
        $job = new FetchAccountJob($handle);

        $mInstagram = Mockery::mock(Instagram::class);
        $raw = unserialize(file_get_contents(base_path('/tests/resources/account.txt')));
        $mInstagram->shouldReceive('getAccount')
            ->with($handle)
            ->andReturn($raw);

        $account = $job->handle($mInstagram);

        $expected = [
            'id' => '2139692575',
            'followers' => 445,
            'following' => 1348243,
            'media_count' => 2234,
            'username' => 'third_eye_thirst',
        ];

        $this->assertEquals($expected, $account->toJson());
    }
}
