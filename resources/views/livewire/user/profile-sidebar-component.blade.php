<div class="profile-sidebar text-center shadow-sm">
    <div class="owner-info mb-4 text-dark">

        <div class="pro-img"
            style="height:100px;
            width:100px;
            background: white;
            background-size: contain;
            border-radius: 50%;
            margin: auto;
            overflow:hidden;
            background-position: center;
            background-repeat: no-repeat;
            ">
            {{-- <img class="img-responsive" height="100%" src="{{ $avatarUrl }}" alt=""> --}}
            <img height="100%" src="{{ get_user_avatar($user['id'], [100, 100]) }}" alt="{{ __('User Avatar') }}"
            class="img-responsive avatar rounded-circle">
        </div>

        <p class="h3 text-dark">{{ $user['first_name']." ".$user['last_name'] }}</p>
        {{-- <p class="h3 text-light">{{ $user->location }}</p> --}}
        <strong class="count-reviews mt-2">
            @if ($allreviewsCount > 0)
                {{ number_format(round((float)$averageRating, 1), 1) }} <i class="fas fa-star" style="font-size: 1rem;color: #ffe120;margin-left: 3px;margin-right: 3px;"></i> <span
                        class="count">{{ _n(__('(%s review)'), __('(%s reviews)'), $allreviewsCount) }}</span>
            @else
               No reviews yet
            @endif
        </strong>


        <div class="dropdown-divider mt-3"></div>
    </div>


    @livewire('user.profile-share-component', ['user'=> $user])

</div>
