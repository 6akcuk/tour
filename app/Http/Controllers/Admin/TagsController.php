<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagsRequest;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::with('posts')->orderBy('tag')->paginate(50);

        return view('admin.blogs.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        $tag = Tag::findOrFail($id);

        if ($request->has('q')) {
            $posts = $tag->posts()->where('title', 'like', '%'. $request->input('q') .'%')->paginate(10);
        }
        else {
            $posts = $tag->posts()->paginate(10);
        }

        return view('admin.blogs.tags.show', compact('posts', 'tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.blogs.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TagsRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update([
            'tag' => $request->tag
        ]);

        flash()->success('Successfully updated.');

        return redirect(route('admin.blogs.tags.edit', $tag));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        flash()->success('Successfully deleted.');

        return redirect(route('admin.blogs.tags.index'));
    }
}
