<?php

namespace App\Data\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self PHOTO()
 * @method static self VIDEO()
 * @method static self CAROUSEL()
 */
class MediaType extends Enum
{
    private const PHOTO = 'photo';
    private const VIDEO = 'video';
    private const CAROUSEL = 'carousel';
}
