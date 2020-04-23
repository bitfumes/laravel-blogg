<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Http\Request;
use Bitfumes\Blogg\Models\Tag;
use Bitfumes\Blogg\Models\Blog;
use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Models\Category;
use Bitfumes\Blogg\Events\BlogVisited;
use Illuminate\Support\Facades\Storage;
use Bitfumes\Blogg\Http\Requests\BlogRequest;
use Symfony\Component\HttpFoundation\Response;
use Bitfumes\Blogg\Http\Resources\BlogResource;
use Bitfumes\Blogg\Http\Resources\BlogCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;
    private $blogsResource;
    private $blogResource;

    public function __construct()
    {
        $this->blogResource  = config('blogg.resources.blog');
        $this->blogsResource = config('blogg.resources.blogs');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginate = app()['config']['blogg.paginate'];
        $blogs    = Blog::published()->with('category', 'likeCounts')->paginate($paginate);
        return $this->blogsResource::collection($blogs);
    }

    /**
     * Display a listing of the resource.
     *
     * @return BlogCollection
     */
    public function all()
    {
        $blogs    = Blog::latest()->get();
        return $this->blogsResource::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(BlogRequest $request)
    {
        $this->authorize('create', Blog::class);
        $blog = Blog::store($request);
        return response(new $this->blogResource($blog), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function edit(Blog $blog)
    {
        return new $this->blogResource($blog);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function show(Category $category, Tag $tag, Blog $blog)
    {
        event(new BlogVisited($blog));
        return new $this->blogResource($blog);
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
        $this->authorize('update', $blog);
        $blog->updateAll($request);
        return response(new $this->blogResource($blog), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return void
     */
    public function destroy(Category $category, Blog $blog)
    {
        $this->authorize('delete', $blog);
        $blog->delete();
        $disk     = config('blogg.storage.disk');
        Storage::disk($disk)->delete("{$blog->image}.jpg");
        Storage::disk($disk)->delete("{$blog->image}_thumb.jpg");
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function byCategory(Category $category)
    {
        $paginate         = app()['config']['blogg.paginate'];
        $blogs            = $category->blogs()->published()->with('category', 'likeCounts', 'likes', 'user', 'tags', 'category')->paginate($paginate);
        return $this->blogResource::collection($blogs);
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return BlogResource
     */
    public function byTag(Tag $tag)
    {
        $paginate         = app()['config']['blogg.paginate'];
        $blogs            = $tag->blogs()->published()->with('category', 'likeCounts', 'likes', 'user', 'tags', 'category')->paginate($paginate);
        return $this->blogResource::collection($blogs);
    }
}
