<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Bitfumes\Blogg\Models\Blog;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function likeIt(Blog $blog)
    {
        $blog->likeIt();
        return response('success', Response::HTTP_CREATED);
    }

    public function unLikeIt(Blog $blog)
    {
        $blog->unLikeIt();
        return response('success', Response::HTTP_CREATED);
    }
}
