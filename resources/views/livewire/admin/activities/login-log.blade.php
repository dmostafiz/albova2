@if(!$preview)
<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
            Sign-in Logs
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($logins) > 0)
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">User Type</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($logins as $item)
              <tr>
                <td>{{ $item->created_at->format("d M, Y") }}</td>
                <td>{{ $item->user->first_name." ".$item->user->last_name }}</td>
                <td>{{ $item->user->email }}</td>
                <td>{{ $item->user->mobile }}</td>
                <td>{{ get_user_role($item->user->id)->name }}</td>

                <td>
                    {{-- @if($item->status != 'approved')
                        <button wire:click="approve({{ $item->id }})" class="btn btn-success btn-sm shadow">approve</button>
                    @endif --}}

                    <button wire:click="preview({{ $item->id }})" wire:loading.attr="disabled" class="btn btn-info btn-sm shadow">
                        {{-- <div wire:loading wire:target="preview">
                            Loading...
                        </div> --}}
                        Preview
                    </button>
                    <button wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm shadow">Delete</button>
                    {{-- @if($item->status != 'declined')
                    @endif --}}
                </td>
              </tr>
              @endforeach
            </tbody>
            @else

            <h4 class="text-center">No data found</h4>

          @endif
        </table>

        @if($loadMore)
        <div class="text-center pt-2">
            <button wire:click="loadMore()" class="btn btn-info btn-sm shadow-sm">Load More</button>
        </div>
        @endif

    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>

@else

 <div class="card">
    <div class="card-header bg-white">
        Login informations<br>
        <div style="font-weight: 900">
            {{ $previewInfo->user->email }}
            <button wire:click="goBack()" class="btn btn-primary btn-sm shadow float-right">Go Back</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-header" style="font-weight: 900">Login informations</h4>
                <table class="table table-sm mb-0 dt-responsive nowrap w-100">
                    <tr>
                        <td>Loged in</td>
                        <td>{{ $previewInfo->created_at->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <td>User Name</td>
                        <td>{{ $previewInfo->user->first_name." ".$previewInfo->user->last_name }}</td>
                    </tr>
                    <tr>
                        <td>User Email</td>
                        <td>{{ $previewInfo->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Device</td>
                        <td>{{ $previewInfo->device }}</td>
                    </tr>
                    <tr>
                        <td>Platform</td>
                        <td>{{ $previewInfo->platform . " " . $previewInfo->platform_version }}</td>
                    </tr>
                    <tr>
                        <td>Browser</td>
                        <td>{{ $previewInfo->browser . " " . $previewInfo->browser_version }}</td>
                    </tr>
                    <tr>
                        <td>User IP</td>
                        <td>{{ $previewInfo->ip_type." - ".$previewInfo->ip }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $previewInfo->city }}</td>
                    </tr>
                    <tr>
                        <td>Postal Code</td>
                        <td>{{ $previewInfo->postal }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $previewInfo->country }}</td>
                    </tr>
                    <tr>
                        <td>Region</td>
                        <td>{{ $previewInfo->region }}</td>
                    </tr>
                    <tr>
                        <td>continent</td>
                        <td>{{ $previewInfo->continent }}</td>
                    </tr>
                    <tr>
                        <td>Time Zone</td>
                        <td>{{ $previewInfo->time_zone }}</td>
                    </tr>
                    <tr>
                        <td>Time Zone</td>
                        <td>{{ $previewInfo->time_zone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Organization</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $previewInfo->org_name }}</td>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td>{{ $previewInfo->org_type }}</td>
                    </tr>
                    <tr>
                        <td>Route</td>
                        <td>{{ $previewInfo->org_route }}</td>
                    </tr>
                    <tr>
                        <td>Domain</td>
                        <td>{{ ($previewInfo->org_domain) ? $previewInfo->org_domain : 'No domain' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h4 class="card-header" style="font-weight: 900">Matching with others Login</h4>
                <table class="table table-sm mb-0 dt-responsive nowrap w-100">

                    <thead>
                        <tr>
                            <td>User Email</td>
                            <td>Posiblity</td>
                            <td>Loged-in at</td>
                            <td>Preview</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matchings as $item)
                        {{-- {{ $item['created_at'] }} --}}
                            <tr>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['percent'] }}%</td>
                                <td>{{ get_readable_time($item['created_at']) }}</td>
                                {{-- <td>{{ get_readable_time($item['created_at']) }}</td> --}}
                                <td>
                                    <button wire:click="preview({{ $item['id']}})" wire:loading.attr="disabled" class="btn btn-info btn-sm shadow">
                                        {{-- <div wire:loading wire:target="preview">
                                            Loading...
                                        </div> --}}
                                        Preview
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>

    </div>
 </div>

@endif

