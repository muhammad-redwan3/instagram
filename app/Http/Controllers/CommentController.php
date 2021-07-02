<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => ['required', 'integer'],
            'comment' => ['required', 'string', 'max:255']
        ]);
        $post = post::findOrFail($request->post_id);
        $user_id = auth()->user()->id;

        $post->comments()->create(
            [
                'user_id' => $user_id,
                'comment' => $data['comment'],
            ]
        );

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(comment $comment)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(comment $comment)
    {
        if ($comment == null) {
            abort(404);
        }
        $this->authorize('update', $comment);
        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comment $comment)
    {
        if ($comment == null) {
            abort(404);
        }

        $this->authorize('update', $comment);
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:255']
        ]);

        $comment->update([
            'comment' => $data['comment']
        ]);

        return redirect('posts/' . $comment->post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        if ($comment == null) {
            abort(404);
        }
        $this->authorize('delete', $comment);
        $comment->delete();
        return back();
    }
}
