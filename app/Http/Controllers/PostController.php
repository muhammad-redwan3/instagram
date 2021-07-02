<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except(['show']);
    }
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = request()->validate([
            'post_caption' => 'string',
            'image_path' => ['required', 'image']
        ]);

        //resimler kayted etmek icin kullaniyoruz
        $imagepath = request('image_path')->store('uploads', 'public');

        auth()->user()->posts()->create([
            'post_caption' => $date['post_caption'],
            'image_path' => $imagepath,
        ]);

        return redirect()->route('user_profile', ['username' => auth()->user()->username]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
        if ($post == null) {
            abort(404);
        }
        //لعدم وصول أي شخص إلى أي منشور من منشورات المتسخدم التي ييكون صابحبها يملك حساب خاص 
        if (auth()->user() != null || $post->user->status == 'private') {
            $this->authorize('view', $post);
        }
        return view('posts.view', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        if ($post == null) {
            abort(404);
        }
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        if ($post == null) {
            abort(404);
        }

        $this->authorize('update', $post);  // لتتحق في حال كان المستخدم يملك المنشور الذي يريد التعديل عليه

        $date = request()->validate([
            'post_caption' => 'string',
            'image_path' => ['required', 'image']
        ]);

        $imagepath = null;
        if (request('image_path') != null) {
            $imagepath = request('image_path')->store('uploads', 'public');
        } elseif ($post->image_puth != null) {

            $imagepath = $post->image_puth;
        } else {
            abort(401);
        }

        $post->update([
            'image_path' => $imagepath,
            'post_caption' => $date['post_caption']
        ]);

        return redirect(auth()->user()->username);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        if ($post == null) {
            abort(404);
        }

        $this->authorize('delete', $post);
        $post->delete();
        Storage::delete("public/" . $post->image_path);

        return redirect(auth()->user()->username);
    }
}
