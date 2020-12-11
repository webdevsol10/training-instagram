<?php

namespace App\Data\Models;

use DateTime;
use JsonSerializable;
use App\Data\Enums\Source;
use App\Data\Collections\MediaCollection;

class Insights implements JsonSerializable
{
    public string $platform = 'instagram';
    public string $username;
    public string $platformId;
    public Source $source;
    public int $fetchedAt;
    public Account $account;
    public MediaCollection $medias;

    public function __construct(
        string $username,
        string $platformId,
        Source $source,
        int $fetchedAt,
        Account $account,
        MediaCollection $medias
    ) {
        $this->username = $username;
        $this->platformId = $platformId;
        $this->source = $source;
        $this->fetchedAt = $fetchedAt;
        $this->account = $account;
        $this->medias = $medias;
    }

    public static function makeFromScraper(Account $account, MediaCollection $medias): self
    {
        return new self(
            $account->username,
            $account->id,
            Source::SCRAPER(),
            time(),
            $account,
            $medias
        );
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'platform_id' => $this->platformId,
            'platform' => $this->platform,
            'source' => $this->source->getValue(),
            'fetched_at' => $this->fetchedAt,
            'insights' => [
                'account' => $this->account->toArray(),
                'content' => $this->medias->toArray(),
            ]
        ];
    }

    public function jsonSerialize ()
    {
        return $this->toArray();
    }
}
