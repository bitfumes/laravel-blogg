<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Bitfumes\Blogg\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        $blogs = auth()->user()->blogs()->paginate(50);
        return $this->blogsResource::collection($blogs);
    }
}
