<?php

namespace App\Http\Controllers\Colaboradores;

use App\Http\Controllers\Controller;

class UploadImageController extends Controller
{
    public function __invoke()
    {
        $image = base64_encode(file_get_contents($request->file('image')->pat‌​h()));

        return response()->json();
    }
}
