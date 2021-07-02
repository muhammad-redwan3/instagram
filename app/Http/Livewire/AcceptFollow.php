<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class AcceptFollow extends Component
{

    public $profile_id;
    private $profile;
    public $status;

    public function mount($profile_id)
    {
        $this->profile = User::find($profile_id);
        if ($this->profile != null && auth()->user() != null) {
            auth()->user()->accepted($this->profile) ? $this->status = 'Accepted' : $this->status = 'Accept';
        }
    }

    public function toggleAccept($profile_id)
    {
        $this->profile = User::find($profile_id);
        if ($this->profile != null && auth()->user() != null) {
            if (auth()->user()->accepted($this->profile)) {
                auth()->user()->toggleAccept($this->profile, false);
                auth()->user()->accepted($this->profile) ? $this->status = 'Accepted' : $this->status = 'Accept';
            } else {
                auth()->user()->toggleAccept($this->profile, true);
                auth()->user()->accepted($this->profile) ? $this->status = 'Accepted' : $this->status = 'Accept';
            }
        }
    }
    public function render()
    {
        return view('livewire.accept-follow');
    }
}
