<?php

namespace App\Http\Controllers\Tags;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $tag = Tag::findOrFail($id);

        return new TagResource($tag);
    }
}
