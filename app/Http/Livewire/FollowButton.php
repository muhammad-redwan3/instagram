<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\User;

class Followerbutton extends Component
{
    private $profile;
    public $profile_id;
    public $following = "follow";

    public function mount($profile_id)
    {
        $this->profile = User::find($profile_id);

        if ($this->profile != null && auth()->user() != null) {
            auth()->user()->following($this->profile) ? $this->following = "unfollow" : $this->following = "follow";
        }
    }

    public function toggelfollow($profile_id)
    {
        $this->profile = User::find($profile_id);

        if ($this->profile != null && auth()->user() != null) {
            auth()->user()->follows()->toggle($this->profile);

            auth()->user()->following($this->profile) ? $this->following = "unfollow" : $this->following = "follow";
            auth()->user()->setaccepted($this->profile);
        } else {
            redirect(route('login'));
        }
    }
    public function render()
    {
        return view('livewire.followerbutton');
    }
}
