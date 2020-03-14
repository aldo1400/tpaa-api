<?php

namespace App\Http\Traits;

trait ImageTrait
{
    public function uploadImage($request)
    {
        $image = base64_encode(file_get_contents($request->file('image')->pat‌​h()));

        return $image;
    }
}
