
<div class="mt-4">

    @php
      $year =  explode("-", $user['created_at'] );
    @endphp

    <h3>Hi, i am {{  $user['first_name'] .' '. $user['last_name'] }}</h3>
    <span class="text-muted">Joined in {{ $year[0] }}</span>

    @if($user['description'] != null)

        <h3 class="mt-3">About</h3>
        {!! $user['description'] !!}

    @endif


    @if(count($experiences))
    <h3 class="heading mt-4 mb-3">{{ $user['first_name']."'s " . __('Experiences')}}</h3>
    <div class="hh-list-of-services list-experience">
        <div class="row">
            @foreach($experiences as $item)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    @include('frontend.experience.loop.grid', ['item' => $item, 'show_distance' => true])
                </div>
            @endforeach
            @if($loadMore)
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary btn-sm" wire:click="loadMore()" >Load more experiences</button>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>






{{-- <div class="row">

    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
       <div class="hh-service-item experience grid" data-plugin="matchHeight" data-lng="-73.590868" data-lat="45.4513" data-id="112" style="height: 420.188px;">
          <a href="http://albova.exc/experience/112/nattes-1603003981">
             <div class="thumbnail">
                <div class="thumbnail-outer">
                   <div class="thumbnail-inner">
                      <img src="//via.placeholder.com/650x550" alt="121685740_400106264337762_8297751389437311688_n" class="img-fluid" />
                   </div>
                </div>
             </div>
          </a>
          <div class="detail">
             <div class="address">
                rue allard, Canada
                <strong>(0.05km)</strong>
             </div>
             <a class="title mb-1" href="http://albova.exc/experience/112/nattes-1603003981"> Nattes</a>
             <div class="duration d-flex align-items-center">
                <span class="mr-1">
                   <i class="hh-icon fa">
                      <svg height="15px" width="15px" version="1.1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512;" xml:space="preserve">
                         <g fill="#4a4a4a">
                            <g fill="#4a4a4a">
                               <g fill="#4a4a4a">
                                  <path
                                     d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M266.667,490.126v-31.46
                                     c0-5.896-4.771-10.667-10.667-10.667s-10.667,4.771-10.667,10.667v31.46c-120.868-5.473-217.987-102.591-223.46-223.46h31.46
                                     C59.229,266.667,64,261.896,64,256s-4.771-10.667-10.667-10.667h-31.46c5.473-120.868,102.591-217.987,223.46-223.46v31.46
                                     C245.333,59.229,250.104,64,256,64s10.667-4.771,10.667-10.667v-31.46c120.868,5.473,217.987,102.591,223.46,223.46h-31.46
                                     c-5.896,0-10.667,4.771-10.667,10.667s4.771,10.667,10.667,10.667h31.46C484.654,387.535,387.535,484.654,266.667,490.126z"
                                     ></path>
                                  <path
                                     d="M276.281,261.198c0.441-1.707,1.052-3.355,1.052-5.198c0-4.465-1.698-8.382-4.053-11.811l67.053-143.678
                                     c2.49-5.333,0.188-11.688-5.156-14.177C329.854,83.885,323.5,86.167,321,91.49l-67.005,143.583
                                     c-10.776,1.063-19.328,9.878-19.328,20.927c0,11.76,9.573,21.333,21.333,21.333c1.842,0,3.491-0.611,5.198-1.052l83.26,83.26
                                     c2.083,2.083,4.813,3.125,7.542,3.125c2.729,0,5.458-1.042,7.542-3.125c4.167-4.167,4.167-10.917,0-15.083L276.281,261.198z"
                                     ></path>
                               </g>
                            </g>
                         </g>
                      </svg>
                   </i>
                </span>
                3h
             </div>
             <div class="w-100 mt-1"></div>
             <div class="d-flex align-items-center justify-content-between">
                <div class="price-wrapper">
                   <span class="unit">
                   <span class="price">$90.00</span>
                   </span>
                </div>
             </div>
          </div>
       </div>
    </div>

 </div> --}}
