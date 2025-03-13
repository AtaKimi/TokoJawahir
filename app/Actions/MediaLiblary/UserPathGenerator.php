<?php

namespace App\Actions\MediaLiblary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media);
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . 'responsive-images/';
    }

    public function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');

        if ($prefix !== '') {
            return $prefix.'/'. 'users/' . $media->getKey() . '/';
        }
    }
}