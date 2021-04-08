<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PublicProfileComponent extends Component
{

    // public $userEmail;
    // public $userId;
    public $user;

    public function mount($user)
    {
        // $this->userEmail = $user->email;
        // $this->userId = $user->id;
        $this->user = $user->toArray();
    }

    public function render()
    {
        return view('livewire.public-profile-component');
    }
}
