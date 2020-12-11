<?php

namespace App\Domains\Fetch\Jobs;

use Lucid\Units\Job;
use App\Data\Models\Account;
use InstagramScraper\Instagram;

class FetchAccountJob extends Job
{
    private string $handle;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    public function handle(Instagram $instagram): Account
    {
        $raw = $instagram->getAccount($this->handle);

        return Account::makeFromScraper($raw);
    }
}
