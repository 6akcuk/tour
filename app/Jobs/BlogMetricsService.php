<?php

namespace App\Jobs;

use App\BlogCategory;
use App\Jobs\Job;
use App\Post;
use App\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class BlogMetricsService extends Job implements SelfHandling
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

    public function posts()
    {
        return Post::count();
    }

    public function categories()
    {
        return BlogCategory::count();
    }

    public function tags()
    {
        return Tag::count();
    }
}
