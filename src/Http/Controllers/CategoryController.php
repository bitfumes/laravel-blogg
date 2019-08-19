<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Models\Category;
use Bitfumes\Blogg\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    private $categoryResource;
    private $category;

    public function __construct()
    {
        $this->categoryResource   = config('blogg.resources.category');
        $this->middleware(config('blogg.middleware'))->except('index', 'show');
        $this->category = config('blogg.models.category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category::all();
        return $this->categoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->category::create($request->all());
        return response($category, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = $this->category::whereSlug($category)->first();
        return new $this->categoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $category)
    {
        $category = $this->category::whereSlug($category)->first();
        $category->update($request->except(['_method']));
        return response($category, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $blog
     * @return void
     */
    public function destroy($category)
    {
        $category = $this->category::whereSlug($category)->first();
        $category->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function search($query)
    {
        $result = $this->category::where('name', 'like', "%$query%")->get();
        return $this->categoryResource::collection($result);
    }
}
