<?php

namespace App\Domains\Fetch\Jobs;

use Lucid\Units\Job;
use InstagramScraper\Instagram;
use App\Data\Collections\MediaCollection;

class FetchContentJob extends Job
{
    private string $handle;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    public function handle(Instagram $instagram): MediaCollection
    {
        // @TODO paginate to get 20 posts
        $medias = $instagram->getMedias($this->handle);

        // @TODO only take 20
        return MediaCollection::makeFromScraper($medias);
    }
}
