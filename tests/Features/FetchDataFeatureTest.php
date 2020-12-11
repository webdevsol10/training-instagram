<?php

namespace App\Tests\Features;

use Tests\TestCase;
use App\Features\FetchDataFeature;

class FetchDataFeatureTest extends TestCase
{
    public function test_fetching_data()
    {
        $handle = 'thehandle';

        $f = new FetchDataFeature($handle);

        $f->handle();
    }
}
