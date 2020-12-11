<?php

namespace App\Data\Models;

use DateTime;
use App\Data\Enums\MediaType;
use Illuminate\Contracts\Support\Arrayable;
use App\Exceptions\InvalidMediaTypeException;
use InstagramScraper\Model\Media as ScraperMedia;

class Media implements Arrayable
{
    public string $id;
    public string $code;
    public MediaType $type;
    public string $link;
    public string $thumbnailUrl;
    public bool $isAd;
    public DateTime $createdAt;
    public ?string $caption;
    public ?int $likes;
    public ?int $comments;
    public ?int $video_views;

    public function __construct(
        string $id,
        string $code,
        MediaType $type,
        string $link,
        string $thumbnailUrl,
        bool $isAd,
        DateTime $createdAt,
        ?string $caption = '',
        ?int $likes = 0,
        ?int $comments = 0,
        ?int $video_views = 0
    ) {

        $this->id = $id;
        $this->code = $code;
        $this->type = $type;
        $this->link = $link;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->isAd = $isAd;
        $this->createdAt = $createdAt;
        $this->caption = $caption;
        $this->likes = $likes;
        $this->comments = $comments;
        $this->video_views = $video_views;
    }

    /**
     * @param ScraperMedia $data
     *
     * @return static
     * @throws InvalidMediaTypeException
     */
    public static function makeFromScraper(ScraperMedia $data): self
    {
        $type = $data->getType();
        switch ($type) {
            case 'image':
                $type = MediaType::PHOTO();
                break;
            case 'sidecar':
                $type = MediaType::CAROUSEL();
                break;
            case 'video':
                $type = MediaType::VIDEO();
                break;
            default:
                throw new InvalidMediaTypeException($type);
        }

        return new self(
            $data->getId(),
            $data->getShortCode(),
            $type,
            $data->getLink(),
            $data->getImageThumbnailUrl(),
            $data->isAd(),
            (new DateTime)->setTimestamp($data->getCreatedTime()),
            $data->getCaption(),
            $data->getLikesCount(),
            $data->getCommentsCount(),
            $data->getVideoViews()
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type->getValue(),
            'link' => $this->link,
            'thumbnail_url' => $this->thumbnailUrl,
            'is_ad' => $this->isAd,
            'created_at' => $this->createdAt->getTimestamp(),
            'caption' => $this->caption,
            'likes' => $this->likes,
            'comments' => $this->comments,
            'video_views' => $this->video_views,
        ];
    }

    public function toJson()
    {
        return $this->toArray();
    }
}
