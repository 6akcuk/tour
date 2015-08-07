<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Requests\PostsRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    protected function uploadPostPhoto(Request $request)
    {
        $folder = date('Y-m-d');
        $disk = Storage::disk('blog');
        $disk->makeDirectory($folder);

        $photo = '';

        if ($request->hasFile('photo')) {
            $photo = $folder .'/'. $request->file('photo')->getClientOriginalName();
            $disk->put($photo, File::get($request->file('photo')));
        }

        return $photo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->lists('name', 'id');
        $tags = Tag::lists('tag');

        return view('admin.blogs.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostsRequest|Request $request
     * @return Response
     */
    public function store(PostsRequest $request)
    {
        $photo = $this->uploadPostPhoto($request);

        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'author_id' => Auth::user()->id,
            'photo' => $photo,
            'body' => $request->body
        ]);

        $post->tags()->sync(Tag::getTagsIdsList($request->tags));

        flash()->success('Post successfully created.');

        return redirect(route('admin.blogs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.blogs.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = BlogCategory::orderBy('name')->lists('name', 'id');
        $tags = Tag::lists('tag');

        return view('admin.blogs.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PostsRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $photo = $this->uploadPostPhoto($request);

        $update = [
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'body' => $request->body
        ];

        if ($photo != '' && $post->photo != $photo) {
            $update['photo'] = $photo;
            Storage::disk('blog')->delete($post->photo);
        }

        $post->update($update);

        $post->tags()->sync(Tag::getTagsIdsList($request->tags));

        flash()->success('Successfully updated.');

        return redirect(route('admin.blogs.posts.edit', $post));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->photo)
            Storage::disk('blog')->delete($post->photo);

        $post->delete();

        flash()->success('Successfully deleted.');

        return redirect(route('admin.blogs.index'));
    }
}
