<?php

use App\Models\User;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\comment;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/home', function () {
        // $profile = auth()->user();
        // $ifollow = $profile->iFollow()->take(3);
        // $tofollow  = $profile->otherusers()->take(3);

        $followersPost = \App\Models\post::whereHas('user', function ($user) {
            $user->whereHas('follows', function ($follows) {
                $follows->where('accepted', '1');
                // $follows->where('user_id', auth()->user()->id);
                $follows->where('user_id', auth()->user()->id);
                // $follows->where('users.id', auth()->user()->id);
            });
        })->get();
        // dd($followersPost->toArray());


        return view('home', ['posts' => $followersPost]);
    })->name('home');


    Route::get('/explore', function () {
        return view('explore');
    })->name('explore');

    Route::get('/followers', function () {
        return view('followers', ['profile' => auth()->user(), 'followers' => auth()->user()->followers()->get()]);
    })->name('followers');

    Route::get('/following', function () {
        return view('following', ['profile' => auth()->user(), 'following' => auth()->user()->follows()->get()]);
    })->name('following');


    Route::get('/inbox', function () {
        $user = auth()->user();
        $requsets = $user->followReq();
        $pendings = $user->pendingfollowing();
        return view('inbox', ['profile' => $user, 'requsets' => $requsets, 'pendings' => $pendings]);
    })->name('inbox');

    Route::resource('comments', CommentController::class);
});

Route::get('/', function () {
    return redirect()->route('login');
});



Route::get('{username}', function ($username) {
    $user = User::where('username', $username)->first();
    if ($user == null) {
        abort(404);
    }
    $posts = $user->posts;
    return view('profile', ['profile' => $user, 'posts' => $posts]);
})->name('user_profile');


Route::resource('posts', PostController::class);
