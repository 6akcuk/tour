<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Requests\BlogCategoriesRequest;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $categories = BlogCategory::where('name', 'like', '%' . $request->input('q') .'%')->paginate(20);
        }
        else {
            $categories = BlogCategory::paginate(20);
        }

        return view('admin.blogs.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.blogs.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(BlogCategoriesRequest $request)
    {
        BlogCategory::create([
            'name' => $request->name
        ]);

        flash()->success('Category created.');

        return redirect(route('admin.blogs.categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        if ($request->has('q')) {
            $posts = Post::where('category_id', $id)->where('title', 'like', '%'. $request->input('q') .'%')->paginate(10);
        }
        else {
            $posts = Post::where('category_id', $id)->paginate(10);
        }

        $category = BlogCategory::findOrFail($id);

        return view('admin.blogs.categories.show', compact('posts', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('admin.blogs.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(BlogCategoriesRequest $request, $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->update([
           'name' => $request->name
        ]);

        flash()->success('Successfully saved.');

        return redirect(route('admin.blogs.categories.edit', $category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        flash()->success('Successfully deleted.');

        return redirect(route('admin.blogs.categories.index'));
    }
}
