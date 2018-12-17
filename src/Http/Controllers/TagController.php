<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Models\Tag;
use Bitfumes\Blogg\Http\Resources\TagCollection;
use Bitfumes\Blogg\Http\Resources\TagResource;
use Bitfumes\Blogg\Http\Requests\TagRequest;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Tag::all();
        return new TagCollection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $Tag = Tag::store($request->all());
        return response($Tag, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $Tag)
    {
        return new TagResource($Tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $Tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->except(['_method']));
        return response($tag, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $blog
     * @return void
     */
    public function destroy(Tag $Tag)
    {
        $Tag->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
