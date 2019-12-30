<?php
namespace App\Http\Traits;

trait ImageTrait {
    public function uploadImage($request) {
        // Get all the brands from the Brands Table.
        // $brands = Brand::all();
        $image = base64_encode(file_get_contents($request->file('image')->pat‌​h()));
        return $image;
    }
}