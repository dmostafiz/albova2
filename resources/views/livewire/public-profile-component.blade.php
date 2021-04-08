<div class="row">
   {{-- @livewire('user.profile-share-component', ['user'=> $user]) --}}
   {{-- @livewire('user.user-statistics-component', ['user'=> $user]) --}}
   <div class="col-md-3">
        @livewire('user.profile-sidebar-component', ['user'=> $user])
   </div>
   <div class="col-md-9 pl-4 pr-4">
        @livewire('user.user-experiences-component', ['user'=> $user])
        @livewire('user.user-reviews-component', ['user'=> $user])
   </div>

</div>
