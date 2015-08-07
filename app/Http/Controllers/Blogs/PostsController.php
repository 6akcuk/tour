<?php

namespace App\Http\Controllers\Blogs;

use App\BlogCategory;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsController extends Controller
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
            $posts = Post::latest()->where('title', 'like', '%'. $request->input('q') .'%')->paginate(10);
        }
        else {
            $posts = Post::latest()->paginate(10);
        }

        return view('blogs.posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return view('blogs.posts.show', compact('post'));
    }

    public function category(Request $request, BlogCategory $category)
    {
        if ($request->has('q')) {
            $posts = $category->posts()->latest()->where('title', 'like', '%'. $request->input('q') .'%')->paginate(10);
        }
        else {
            $posts = $category->posts()->latest()->paginate(10);
        }

        return view('blogs.posts.category', compact('posts'));
    }

    public function tag(Request $request, Tag $tag)
    {
        if ($request->has('q')) {
            $posts = $tag->posts()->latest()->where('title', 'like', '%'. $request->input('q') .'%')->paginate(10);
        }
        else {
            $posts = $tag->posts()->latest()->paginate(10);
        }

        return view('blogs.posts.tag', compact('posts'));
    }
}
