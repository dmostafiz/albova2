<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Experience;

class UserExperiencesComponent extends Component
{
    public $userId;
    public $user;
    public $perPage = 4;
    public $shouldLoad = 4;
    public $loadMore = true;
    public $total;

    public function mount($user)
    {
        // dd($user);

        $this->userId = $user['id'];
        $this->user = $user;

        $this->total = Experience::where('author', $this->userId)->get()->count();

        // dd($this->total);

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        // dd($eps);
    }


    public function loadMore()
    {
        // dd('some string from experience');
        $this->perPage = $this->perPage + $this->shouldLoad;

        $this->total = Experience::where('author', $this->userId)->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        // $this->emit('load-more');
    }

    public function render()
    {
        $data['experiences'] = Experience::where('author', $this->userId)->latest()->paginate($this->perPage);
        return view('livewire.user.user-experiences-component',$data);
    }
}
