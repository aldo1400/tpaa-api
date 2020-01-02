<?php

namespace App\Http\Controllers\Tags;

use App\Tag;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }
}
