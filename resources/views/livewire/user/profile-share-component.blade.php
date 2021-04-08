<div class="owner-share">
    <!--
    1. load font awesome with your favorite method
    2. replace items in # #s with details specific to your content
    -->
    @php

    @endphp

    <strong class="h4 text-dark">Share my profile</strong>
    <div id="share" class="mt-2">

        <!-- facebook -->
        <a class="facebook shadow-sm" href="https://www.facebook.com/share.php?u={{ route('public.profile', urlencode($user['email'])) }}" target="blank">
            <i class="fab fa-facebook-f"></i>
        </a>

        <!-- twitter -->
        <a class="twitter shadow-sm" href="https://twitter.com/intent/tweet?status={{ $user['first_name'].' '.$user['last_name'] }}+{{ route('public.profile', urlencode($user['email'])) }}" target="blank">
            <i class="fab fa-twitter"></i>
        </a>

        <!-- google plus -->
        {{-- <a class="googleplus" href="https://plus.google.com/share?url={{ route('public.profile', urlencode($user['email'])) }}" target="blank">
            <i class="fab fa-google-plus"></i>
        </a> --}}

        <!-- linkedin -->
        {{-- <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('public.profile', urlencode($user['email'])) }}&title={{ $user['first_name'].' '.$user['last_name'] }}" target="blank">
            <i class="fab fa-linkedin"></i>
        </a> --}}

        <!-- pinterest -->
        <a class="pinterest shadow-sm" href="https://pinterest.com/pin/create/bookmarklet/?media={{ asset('images/profile-cover.jpg') }}&url={{ route('public.profile', urlencode($user['email'])) }}&is_video=false&description={{ $user['first_name'].' '.$user['last_name'] }}" target="blank">
            <i class="fab fa-pinterest-p"></i>
        </a>

    </div>
</div>
