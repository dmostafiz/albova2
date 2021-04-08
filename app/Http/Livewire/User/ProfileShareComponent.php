<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class ProfileShareComponent extends Component
{
    public $user;

    public function mount($user)
    {
       $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.profile-share-component');
    }
}
