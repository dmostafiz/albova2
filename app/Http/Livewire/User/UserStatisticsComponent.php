<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserStatisticsComponent extends Component
{
    public $userId;

    public function mount($user)
    {
        $this->userId = $user['id']; 
    }


    public function render()
    {
        return view('livewire.user.user-statistics-component');
    }
}
