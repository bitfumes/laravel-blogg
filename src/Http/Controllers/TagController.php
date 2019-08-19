<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Bitfumes\Blogg\Models\Tag;
use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Http\Requests\TagRequest;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    private $tagResource;
    private $tag;

    public function __construct()
    {
        $this->tagResource   = config('blogg.resources.tag');
        $this->middleware(config('blogg.middleware'))->except('index', 'show');
        $this->tag = config('blogg.models.tag');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->tag::all();
        return $this->tagResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $Tag = $this->tag::store($request->all());
        return response($Tag, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function show($tag)
    {
        $tag = $this->tag::whereName($tag)->first();
        return new $this->tagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $tag)
    {
        $tag = $this->tag::whereName($tag)->first();

        $tag->update($request->except(['_method']));
        return response($tag, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $blog
     * @return void
     */
    public function destroy($tag)
    {
        $tag = $this->tag::whereName($tag)->first();
        $tag->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
