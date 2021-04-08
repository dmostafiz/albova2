<div>

    {{-- <div class="home-comment-list mt-3">
        <h3 class="comment-count">
            0 reviews for this property
        </h3>
    </div> --}}

    <div class="review-list mt-3 pb-3" style="border-bottom: 2px solid #f3f3f3;
    padding-bottom: 8px;">
        <strong class="reviews-title h3 mr-5">All Reviews</strong>
        <strong class="count-reviews mt-2 float-right">
            {{ number_format(round((float)$averageRating, 1), 1) }} <i class="fas fa-star" style="font-size: 1rem;color: #ffe120;margin-left: 3px;margin-right: 3px;"></i> <span
                    class="count">{{ _n(__('(%s review)'), __('(%s reviews)'), $allreviewsCount) }}</span>
        </strong>
    </div>

    <div class="reviews">

        @foreach ($reviews as $item)

          @php
             $author = DB::table('users')->where('id', $item->comment_author)->first();
             $avatar = DB::table('media')->where('media_id', $author->avatar)->first();
             if($avatar)
             {
                 $avatar_url =  $avatar->media_url;
             }
             else
             {
                $avatar_url =  "https://via.placeholder.com/150";
             }
            //  dd($avatar);
          @endphp

            <div class="media mt-3">
                <img width="50" class="mr-3" style="border-radius: 50%" src="{{ $avatar_url }}" alt="Generic placeholder image">
                <div class="media-body">
                <h5 class="mt-0">{{ $author->first_name.' '.$author->last_name  }}
                    <span class="ml-3"><i class="fas fa-star" style="font-size: 1rem;color: #ffe120;margin-left: 3px;margin-right: 3px;"></i> {{ $item->comment_rate }}</span></h5>
                  {{ $item->comment_content }}
                </div>
            </div>

        @endforeach


        @if($loadMore)
            <div class="divider"></div>

            <div class="ml-5">
                <a href="javascript: void(0)"  wire:click="loadMore()" >
                   <strong>+ See more</strong>
                </a>
            </div>
        @endif

    </div>

</div>
