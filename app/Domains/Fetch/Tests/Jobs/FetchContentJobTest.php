<?php

namespace App\Domains\Fetch\Tests\Jobs;

use InstagramScraper\Instagram;
use App\Domains\Fetch\Jobs\FetchContentJob;
use Tests\TestCase;

class FetchContentJobTest extends TestCase
{
    public function test_fetch_content_job()
    {
        $handle = 'third_eye_thirst';
        $job = new FetchContentJob($handle);

        $raw = unserialize(file_get_contents(base_path('tests/resources/content.txt')));
        $mInstagram = \Mockery::mock(Instagram::class);
        $mInstagram->shouldReceive('getMedias')
            ->with($handle)
            ->andReturn($raw);

        $medias = $job->handle($mInstagram);

        $expected = [
            "id" => "2461406304977985036",
            "code" => "CIoq_5IHp4M",
            "type" => "photo",
            "link" => "https://www.instagram.com/p/CIoq_5IHp4M",
            "thumbnail_url" => "https://instagram.fbey5-2.fna.fbcdn.net/v/t51.2885-15/e35/130872977_186327136481836_218482334538455442_n.jpg?_nc_ht=instagram.fbey5-2.fna.fbcdn.net&_nc_cat=104&_nc_ohc=CrxKcSKOD1sAX9QaTOA&tp=1&oh=bfd70dcb383b5f45db4d7f56576fb4d5&oe=5FFC7858",
            "is_ad" => false,
            "created_at" => 1607642518,
            "caption" => "Yes 🙏🖤🦋 highly encourage following @thelovechange 💫",
            "likes" => 4980,
            "comments" => 18,
            "video_views" => 0,
        ];

        // @TODO find an account that has videos, change cached content and assert video.

        $this->assertEquals(20, $medias->count());
        $this->assertEquals($expected, $medias->first()->toArray());
    }
}
