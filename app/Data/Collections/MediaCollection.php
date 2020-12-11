<?php

namespace App\Data\Collections;

use App\Data\Models\Media;
use Illuminate\Support\Collection;

class MediaCollection extends Collection
{
    public static function makeFromScraper(array $data): self
    {
        // @TODO handle InvalidMediaException
        return new self(array_map(fn($media) => Media::makeFromScraper($media), $data));
    }
}
