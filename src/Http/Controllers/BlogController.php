<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Http\Request;
use Bitfumes\Blogg\Models\Blog;
use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Http\Resources\BlogResource;
use Bitfumes\Blogg\Http\Resources\BlogCollection;
use Bitfumes\Blogg\Http\Requests\BlogRequest;
use Symfony\Component\HttpFoundation\Response;
use Bitfumes\Blogg\Models\Category;

class BlogController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return BlogCollection
     */
    public function index()
    {
        $paginate = app()['config']['blogg.paginate'];
        $blogs    = Blog::published()->paginate($paginate);
        return new BlogCollection($blogs);
    }

    /**
     * Display a listing of the resource.
     *
     * @return BlogCollection
     */
    public function all()
    {
        $blogs    = Blog::latest()->get();
        return new BlogCollection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(BlogRequest $request)
    {
        // $blog = auth()->user()->createBlog($request);

        $blog = Blog::store($request);
        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function edit(Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function show(Category $category, Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Blog $blog
     * @return void
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->updateAll($request->all());
        return response(null, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return void
     */
    public function destroy(Category $category, Blog $blog)
    {
        $blog->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
