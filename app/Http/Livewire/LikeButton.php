<?php

namespace App\Http\Livewire;

use App\Models\post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    private $post;
    public $post_id;
    public $isliked;
    public $likeCount;

    public function mount($post_id)
    {
        $this->post = post::find($post_id);
        if ($this->post != null && auth()->user() != null) {

            $this->post->likedByUser(auth()->user()) ? $this->isliked = true : $this->isliked = false;
        }
        $this->likeCount = $this->post->likedByUsers->count();
    }

    public function Togglelike($post_id)
    {
        $this->post = post::find($post_id);
        if ($this->post != null && auth()->user() != null) {
            $this->post->likedByUsers()->toggle(auth()->user());
            $this->post->likedByUser(auth()->user()) ? $this->isliked = true : $this->isliked = false;
        } else {
            redirect(route('login'));
        }

        $this->likeCount = $this->post->likedByUsers->count();
    }
    public function render()
    {
        return view('livewire.like-button');
    }
}
