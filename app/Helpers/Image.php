<?php

namespace App\Helpers;

class Image
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public static function convertImage($imagen)
    {
        $image = base64_encode(file_get_contents($imagen->getRealPath()));

        return $image;
    }
}
