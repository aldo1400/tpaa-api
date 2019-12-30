<?php
namespace App\Helpers;
 
class Image {
    /**
     * @param Request $request
     * 
     * @return string
     */
    public static function convertImage($request) {
            $image = base64_encode(file_get_contents($request->file('diploma')->getRealPath()));
            return $image;
    }
}