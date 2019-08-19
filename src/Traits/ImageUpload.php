<?php

namespace Bitfumes\Blogg\Traits;

use Illuminate\Support\Str;
use Bitfumes\Blogg\Helpers\ImageCrop;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    public function uploadImage($image)
    {
        if ($this->validateBase64Image($image)) {
            return $this->cropAndUpload($image);
        } else {
            return $image;
        }
    }

    public function removeAndUpload($newImage)
    {
        if ($this->validateBase64Image($newImage)) {
            $this->removeOldImage();
            return $this->cropAndUpload($newImage);
        } else {
            return $this->image;
        }
    }

    public function validateBase64Image($image)
    {
        preg_match('/^data:(.*);base64/i', $image, $match);
        return count($match);
    }

    protected function cropAndUpload($image)
    {
        $thumb_height   = config('blogg.image.thumb.height');
        $thumb_width    = config('blogg.image.thumb.width');
        $path           = config('blogg.image.path');
        $disk           = config('blogg.storage.disk');
        $filename       = Str::random();

        $ImageToLoad  = str_replace('data:image/jpeg;base64,', '', $image);
        $ImageToLoad  = str_replace('data:image/png;base64,', '', $ImageToLoad);
        $image        = base64_decode($ImageToLoad, true);

        $im             = imagecreatefromstring($image);
        $width          = imagesx($im);
        $height         = imagesy($im);

        $image       = ImageCrop::crop($im, $width, $height);
        Storage::disk($disk)->put("{$path}/{$filename}.jpg", $image);

        $thumb       = ImageCrop::crop($im, $thumb_width, $thumb_height);
        Storage::disk($disk)->put("{$path}/{$filename}_thumb.jpg", $thumb);
        ImageCrop::clearnUp($im);

        unset($image);
        return "{$path}/{$filename}";
    }

    protected function removeOldImage()
    {
        $disk     = config('blogg.storage.disk');
        Storage::disk($disk)->delete("{$this->image}.jpg");
        Storage::disk($disk)->delete("{$this->image}_thumb.jpg");
    }
}
