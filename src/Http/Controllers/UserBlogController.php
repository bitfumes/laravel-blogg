<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Bitfumes\Blogg\Http\Requests\BlogRequest;
use Bitfumes\Blogg\Http\Resources\BlogResource;
use Bitfumes\Blogg\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserBlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->blogResource  = config('blogg.resources.blog');
        $this->blogsResource = config('blogg.resources.blogs');
    }

    public function index()
    {
        $blogs = auth()->user()->blogs()->latest()->paginate(50);
        return $this->blogsResource::collection($blogs);
    }

    public function store(BlogRequest $request)
    {
        $blog = Blog::store($request);
        return response(new $this->blogResource($blog), Response::HTTP_CREATED);
    }
}
