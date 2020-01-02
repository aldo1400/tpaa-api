<?php

namespace App\Http\Controllers\Tags;

use App\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(TagRequest $request)
    {
        Tag::create($request->validated());

        return response()->json(null, 201);
    }
}
