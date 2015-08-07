<?php

namespace App\Jobs;

use App\BlogCategory;
use App\Jobs\Job;
use App\Post;
use App\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class BlogService extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }

    public function getCategories()
    {
        return BlogCategory::orderBy('name')->get();
    }

    public function getRecentPosts()
    {
        return Post::latest()->take(3)->get();
    }

    public function getTags()
    {
        return Tag::has('posts')->take(25)->get();
    }
}
