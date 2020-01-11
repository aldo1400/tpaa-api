<?php

namespace App\Http\Controllers\Tags;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return response()->json();
    }
}
