<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = Page::paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(PageRequest $request)
    {
        Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body
        ]);

        flash()->success('Page successfully created.');

        return redirect()->route('admin.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body
        ]);

        flash()->success('Changes saved.');

        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        flash()->success('Page successfully deleted.');

        return redirect()->route('admin.pages.index');
    }

    public function upload(Request $request)
    {
        $folder = date('Y-m-d');
        $disk = Storage::disk('page');
        $disk->makeDirectory($folder);

        $photo = '';

        if ($request->hasFile('file')) {
            $photo = $folder .'/'. $request->file('file')->getClientOriginalName();
            $disk->put($photo, File::get($request->file('file')));
        }

        return response()->json(['link' => 'uploads/pages/'. $photo]);
    }
}
