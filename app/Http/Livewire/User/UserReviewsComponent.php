<?php

namespace App\Http\Livewire\User;

use App\Models\Comment;
use Livewire\Component;
use App\Models\Experience;

class UserReviewsComponent extends Component
{
    public $userId;
    public $endSlice = 5;
    public $shouldLoad = 5;
    public $loadMore = true;
    public $allreviewsCount;
    public $averageRating;

    public function mount($user)
    {
        $this->userId = $user['id'];

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

        if($this->endSlice >= count($allReviews) )
        {
           $this->loadMore = false;
        }
    }


    public function loadMore()
    {
        $this->endSlice = $this->endSlice + $this->shouldLoad;

       if($this->endSlice >= $this->allreviewsCount )
       {
          $this->loadMore = false;
       }
    }



    public function render()
    {
        $exps = Experience::where('author', $this->userId)->get();


        $allReviews = [];

        foreach($exps as $exp)
        {
           $reviews = Comment::where('post_id', $exp->post_id)->latest()->get();
           foreach($reviews as $rvw)
           {
               $allReviews[] = $rvw;
           }
        }

        usort($allReviews, function($a, $b) {
            return $a->comment_id <= $b->comment_id;
        });

        // dd($allReviews);


        $showReview = array_slice($allReviews, 0, $this->endSlice, true);

        // dd($showReview);

        $data['reviews'] = $showReview;

        return view('livewire.user.user-reviews-component', $data);
    }
}
