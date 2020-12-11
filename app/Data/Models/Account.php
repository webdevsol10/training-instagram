<?php

namespace App\Data\Models;

use InstagramScraper\Model\Account as ScraperAccount;

class Account
{
    public string $id;
    public int $followers;
    public int $following;
    public int $mediaCount;
    public string $username;

    public function __construct(string $id, string $username, int $followers, int $following, int $mediaCount)
    {
        $this->id = $id;
        $this->followers = $followers;
        $this->following = $following;
        $this->mediaCount = $mediaCount;
        $this->username = $username;
    }

    public static function makeFromScraper(ScraperAccount $raw): self
    {
        return new self(
            $raw->getId(),
            $raw->getUsername(),
            $raw->getFollowsCount(),
            $raw->getFollowedByCount(),
            $raw->getMediaCount()
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'followers' => $this->followers,
            'following' => $this->following,
            'media_count' => $this->mediaCount,
        ];
    }

    public function toJson()
    {
        return $this->toArray();
    }

}
