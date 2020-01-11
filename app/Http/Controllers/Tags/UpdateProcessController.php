<?php

namespace App\Http\Controllers\Tags;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->validated());

        return response()->json();
    }
}
