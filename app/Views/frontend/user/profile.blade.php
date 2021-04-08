@include('frontend.components.header')
<div class="hh-checkout-page pb-4">
    {{-- @livewire('user.user-cover-component', ['user'=> $user]) --}}
    <div class="container">

        <div class="row">
           <div class="col-md-12">
               @livewire('public-profile-component', ['user'=>$user])
           </div>
        </div>

    </div>
</div>
@include('frontend.components.footer')
