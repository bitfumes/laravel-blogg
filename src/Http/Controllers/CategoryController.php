<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Http\Request;
use Bitfumes\Blogg\Models\Category;
use Illuminate\Routing\Controller;
use Bitfumes\Blogg\Http\Requests\CategoryRequest;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private $categoryCollection;
    private $categoryResource;
    private $category;

    public function __construct()
    {
        $this->categoryCollection = config('blogg.resource.categoryCollection');
        $this->categoryResource   = config('blogg.resource.category');
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
        return new $this->categoryCollection($categories);
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
    public function show(Category $category)
    {
        return new $this->categoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->except(['_method']));
        return response($category, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $blog
     * @return void
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function search($query)
    {
        $result = $this->category::where('name', 'like', "%$query%")->get();
        return new $this->categoryCollection($result);
    }
}
