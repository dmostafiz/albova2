<?php

namespace App\Http\Livewire\User;

use App\Models\Media;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Experience;

class UserCoverComponent extends Component
{
    public $userId;
    public $user;
    public $avatarUrl;

    public $allreviewsCount;
    public $averageRating;

    public function mount($user)
    {
        $this->userId = $user['id'];
        $this->user = $user;

        $media = Media::where('author', $user['id'])->first();
        if($media)
        {
            $this->avatarUrl = $media->media_url;
        }
        else
        {
            $this->avatarUrl = 'https://via.placeholder.com/150';
        }


        $exps = Experience::where('author', $this->userId)->get();

        $allReviews = [];

        $totalRating = 0;

        foreach($exps as $exp)
        {
           $reviews = Comment::where('post_id', $exp->post_id)->latest()->get();
           foreach($reviews as $rvw)
           {
               $allReviews[] = $rvw;
               $totalRating += $rvw->comment_rate;
           }
        }



        if(count($allReviews) > 0 )
        {
            $this->averageRating = round($totalRating / count($allReviews),1);
        }
        else
        {
            $this->averageRating = 0;
        }


        $this->allreviewsCount = count($allReviews);
    }


    public function render()
    {
        return view('livewire.user.user-cover-component');
    }
}
